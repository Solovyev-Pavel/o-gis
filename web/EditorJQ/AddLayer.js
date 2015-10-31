/* ************************************************************************** *
 *   Copyright © 2015       Pavel Solovyev (solovyev.p.a@gmail.com)           *
 *                          Sergey Sevryukov (sevrukovs@gmail.com)            *
 *                          Alexander Afonin (acer737@yandex.ru)              *
 *                                                                            *
 *   Licensed under the Apache License, Version 2.0 (the "License");          *
 *   you may not use this file except in compliance with the License.         *
 *   You may obtain a copy of the License at                                  *
 *               http://www.apache.org/licenses/LICENSE-2.0                   *
 *                                                                            *
 *   Unless required by applicable law or agreed to in writing, software      *
 *   distributed under the License is distributed on an "AS IS" BASIS,        *
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. *
 *   See the License for the specific language governing permissions and      *
 *   limitations under the License.                                           *
 * ************************************************************************** */

/* ************************************************************************** *
 *          This objects adds new layers to the Composition Editor            *
 * ************************************************************************** */

function CompositionEditorAddLayers(){
    this.parent = null;             // parent class
    this.addCmpData = null;         // Temporary storage for composition-to-add data
    this.rebootLayerTree = false;   // Whether or not we need to empty the window above
    
    // Sets the parent
    this.setParent = function(editor){ this.parent = editor; };
    
    // Opens a window with the list of available layers (and compositions)
    this.showAvaliableLayers = function(){
        if (this.rebootLayerTree){
            $('#' + this.layerListWindow).empty();
            this.rebootLayerTree = false;
        }
        $('#' + this.parent.params.addLayerWindow).dialog("open");
        if ($('#' + this.parent.params.addLayerWindow).children().length === 0){
            var html = '<iframe style="width:99%;height:97%" src="/o-gis/web/app.php/list/layers/global" />';
            $('#' + this.parent.params.addLayerWindow).append(html);
        }
    };
    
    // Adds a layer to the Composition Editor
    this.addThisLayer = function(title, layer_info){
        $('#' + this.parent.params.addLayerWindow).dialog("close");
        var data = layer_info.split('|');
        var layer = {
            cs: data[0].substring(data[0].indexOf(':') + 1),
            workspace: data[0].substring(0, data[0].indexOf(':')),
            projection: data[4],
            name: title,
            type: data[5],
            vis: true,
            transp: 1.0,
            style: { type: 'id', value: '' }, 
            gridvalues: {min: data[1], max: data[2], nodata: data[3]}
        };
        this.parent.composition.layers.push(layer);
        var target = new OpenLayers.Layer.WMS(
                layer.name,
                "/o-gis/web/app.php/wms", {
                    LAYERS: layer.workspace + ':' + layer.cs,
                    format: 'image/png',
                    transparent: true
                }, {
                    projection: this.parent.composition.projection
                }, {
                    singleTile: false,
                    ratio: 1,
                    isBaseLayer: false,
                    displayInLayerSwitcher: true
                });
        this.parent.map.addLayers([target]);
        this.parent.addLayerToTheList(layer.name, target.id, true);
    };
    
    // Prepare a composition for adding to the Composition Editor
    this.addThisComposition = function(title, id){
        var c_editor = this;
        $('#' + this.parent.params.addLayerWindow).dialog("close");
        $.ajax({url: getCompositionData.replace('ID', id), method: 'GET'})
            .done(function(msg){
                if (!msg.success){
                    var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                'The composition "' + title + '" was not found in the database!</td></tr></table>';
                    $( '#messagewindow' ).empty().append(html);
                    $( '#messagewindow' ).dialog("open");
                    return;
                }
                c_editor.addCmpData = msg.data;
                var html = '';
                for (var i = c_editor.addCmpData.layers.length - 1; i >= 0; i--){
                    html += '<div class="addCmpListItem"><label><input type="checkbox" checked="checked" id="layer-for-addition-' +
                            i + '">&nbsp;<b>' + c_editor.addCmpData.layers[i].name + '</b></label></div>';
                }
                var window = $('#' + c_editor.parent.params.addCmpWindow).children()[1].getAttribute('id');
                $('#' + window).empty().append(html);
                $('#' + c_editor.parent.params.addCmpWindow).dialog('open');
            })
            .fail(function(){
                var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                            'Error while loading composition "' + title + '"!</td></tr></table>';
                $( '#messagewindow' ).empty().append(html);
                $( '#messagewindow' ).dialog("open");
                return;
            });
    };
    
    // Cancel the addition of a composition to the Composition Editor
    this.cancelCompositionAddition = function(){
        this.addCmpData = null;
        $('#' + this.parent.params.addCmpWindow).dialog("close");
    };
    
    // Add the selected layer into the Composition Editor
    this.addCompositionLayers = function(){
        $('#' + this.parent.params.addCmpWindow).dialog("close");
        for (var i = 0; i < this.addCmpData.layers.length; i++){
            if ($('#layer-for-addition-' + i).prop('checked')){
                var layer = this.addCmpData.layers[i];
                this.parent.composition.layers.push(layer);
                var target = new OpenLayers.Layer.WMS(
                    layer.name,
                    "/o-gis/web/app.php/wms", {
                        LAYERS: layer.workspace + ':' + layer.cs,
                        format: 'image/png',
                        transparent: true
                    }, {
                        projection: this.parent.composition.projection
                    }, {
                        singleTile: false,
                        ratio: 1,
                        isBaseLayer: false,
                        displayInLayerSwitcher: true
                });
                if (layer.style.type === 'sld'){
                    // for whatever reason, we need to remove escaping of " manually
                    target.mergeNewParams({sld_body: layer.style.value.replace(/\\"/gi, '"')});
                }
                else{ target.mergeNewParams({styles: layer.style.value}); }
                this.parent.map.addLayers([target]);
                this.parent.addLayerToTheList(layer.name, target.id, true);
            }
        }
        this.addCmpData = null;
    };
}
