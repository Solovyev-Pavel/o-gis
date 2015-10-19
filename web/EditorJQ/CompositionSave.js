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
 *       This object implements the methods for saving the composition        *
 * ************************************************************************** */

function CompositionEditorCompositionSave(){
    this.parent = null;         // parent class
    
    // Set the parent
    this.setParent = function(editor){ this.parent = editor; };
    
    // Begin saving the composition
    this.saveTheComposition = function(save_as){
        // filter out un-authenticated users
        var user = this.parent.getUser();
        if (user === null){
            $( "#messagewindow2" ).empty();
            var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                        'You need to be logged in to save a composition!</td></tr></table>';
            $( "#messagewindow2" ).append(html);
            $( "#messagewindow2" ).dialog("open");
            return;
        }
        // if we're performing 'save as' or just saving a new composition -> proceed
        if (save_as || this.parent.composition.id === null){
            var html =  '<table width="100%"><tr><td width="100px">Title:</td><td><input id="composition-name" ' +
                        'style="width:100%"/></td></tr><tr><td>Description:</td><td><textarea id="composition-description" ' +
                        'style="resize:none;width:100%" rows="6"></textarea></td></tr><tr><td>Каталог:</td><td><div ' +
                        'style="display:none" id="targetcatid"></div><div style="width:100%;height:200px;border:1px solid #ccc;" ' +
                        'id="savetargettree"></div></td></tr></table>';
            $('#' + this.parent.params.saveCmpWindow).empty().append(html);
            showSaveTargetCatalogTree(this.parent.user.favRoot);
            $('#' + this.parent.params.saveCmpWindow).dialog("open");
        }
        // otherwise, check if the user is the author of the composition
        else{
            // user that isn't an author can't overwrite the composition either
            if (!save_as && this.parent.composition.id !== null && !this.parent.composition.isAuthor(user.id)){
                $( "#messagewindow" ).empty();
                $( "#messagewindow" ).dialog('option', 'title', 'Saving the composition');
                var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                            'You aren\'t the author of this composition and can\'t change it!</td></tr></table>';
                $( "#messagewindow" ).append(html);
                $( "#messagewindow" ).dialog("open");
                return;
            }
            this.collectCompositionData(save_as);
        }
    };
    
    // Updates composition name and description
    this.applyCompositionData = function(save_as){
        var target = $('#targetcatid').text();
        var c_name = $('#composition-name').val();
        var c_description = $('#composition-description').val();
        if (c_name.trim() === ""){
            alert("Composition title must contain meaningful characters!");
            return;
        }
        if (target === ""){
            alert("You did not select a catalog to put the composition link into!");
            return;
        }
        // remove special characters
        c_name = c_name.replace(/"/g, "''").replace(/'/g, "'").replace(/\\/gi, '\\');
        c_description = c_description.replace(/"/g, "''").replace(/'/g, "'").replace(/\r/gi, '\\r')
                                     .replace(/\n/gi, '\\n').replace(/\\/gi, '\\');
        // apply new name and description
        this.parent.composition.name = c_name;
        this.parent.composition.description = c_description;
        $('#' + this.parent.params.saveCmpWindow).dialog("close");
        this.collectCompositionData(save_as);
    };
    
    // Collects the composition data
    this.collectCompositionData = function(save_as){
        if (this.parent.user !== null){
            this.parent.composition.AddAuthor(this.parent.user.id, this.parent.user.name);
        }
        var extent = this.parent.map.getExtent();
        var layers = this.parent.map.layers;
        // sort layers by their z-index
        layers.sort(function(a, b){ return a.getZIndex() - b.getZIndex(); });
        var target = $('#targetcatid').text();
        var composition = {};
        composition.cmpObjVersion = '0.4';
        composition.authors = this.parent.composition.authors;
        composition.name = this.parent.composition.name;
        composition.description = this.parent.composition.description;
        composition.projection = this.parent.map.projection.projCode;
        composition.extent = { 'type': 'bb', 'minX': extent.left, 'minY': extent.bottom, 'maxX': extent.right, 'maxY': extent.top };
        composition.layers = [];
        for (var i = 0; i < layers.length; i++){
            if (layers[i].params === undefined){ continue; }                    // skip the blank base layer
            if (layers[i].CLASS_NAME !== 'OpenLayers.Layer.WMS'){ continue; }   // skip the non-wms layers
            var full_cs = layers[i].params.LAYERS;
            var cs = full_cs.substring(full_cs.indexOf(':') + 1);
            var ws = full_cs.substring(0, full_cs.indexOf(':'));
            var layer = {
                cs: cs,
                workspace: ws,
                name: layers[i].name,
                vis: layers[i].visibility,
                transp: layers[i].opacity,
                type: this.parent.composition.getLayerType(cs),
                projection: layers[i].projection.projCode,
                gridvalues: this.parent.composition.getLayerMinMaxNodata(cs),
                style: {}
            };
            if (layers[i].params.SLD_BODY === undefined){
                layer.style.type = 'id';
                layer.style.value = layers[i].params.STYLES;
            }
            else{
                layer.style.type = 'sld';
                layer.style.value = layers[i].params.SLD_BODY.replace(/"/g, "\\\"");
            }
            composition.layers.push(layer);
        }
        this.postCompositionData(composition, save_as);
    };
    
    // Send the save composition request
    this.postCompositionData = function(data, save_as){
        var json = JSON.stringify(data);
        var local = "http://" + window.location.hostname;
        var url = '/o-gis/web/app.php/savecomposition';
        url += (this.parent.composition.id === null || save_as) ? '' : '/' + this.parent.composition.id;
        
        var xmlhttp;
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState === 4 ) {
                if(xmlhttp.status === 200){
                    var response = xmlhttp.responseText;
                    if (isNaN(response)){
                        $('#messagewindow').dialog('option', 'title', 'Error while saving the composition!');
                        $('#messagewindow').empty();
                        var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                    'Error:<br/>' + response + '</td></tr></table>';
                        $('#messagewindow').append(html);
                        $('#messagewindow').dialog("open");
                    }
                    else{
                        this.parent.composition.id = response;
                        this.parent.cmpBackUp = this.parent.composition;
                        var pagetitle = this.parent.composition.name +  " :: Composition Editor :: project O-GIS";
                        var pageurl = local + "/o-gis/web/app.php/editor/composition/" + this.parent.composition.id;
                        window.history.pushState({}, pagetitle, pageurl);
                        $('#messagewindow').dialog('option', 'title', 'Composition Saved Successfully!');
                        $('#messagewindow').empty();
                        var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/ok.png"/></td><td valign="middle">' +
                                    'Composition ' + this.parent.composition.name + ' was successfully saved!</td></tr></table>';
                        $('#messagewindow').append(html);
                        $('#messagewindow').dialog("open");
                    }
                }
                else if(xmlhttp.status === 403) {
                    $('#messagewindow').dialog('option', 'title', 'Error while saving the composition!');
                    $('#messagewindow').empty();
                    var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                'Error: illegal action while saving the composition!</td></tr></table>';
                    $('#messagewindow').append(html);
                    $('#messagewindow').dialog("open");
                    this.parent.user = null;
                }
                else {
                    $('#messagewindow').dialog('option', 'title', 'Error while saving the composition!');
                    $('#messagewindow').empty();
                    var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                'Error while saving the composition!</td></tr></table>';
                    $('#messagewindow').append(html);
                    $('#messagewindow').dialog("open");
                }
            }
        };
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "text/plain");
        xmlhttp.send(data);
    };
    
    // Reload the composition from the last save point
    this.reloadComposition = function(){
        if (!window.confirm('Are you sure you want to reload the last saved version of this composition?')){ return; }
        var layer_count = this.parent.map.layers.length - 1;
        for (var i = layer_count; i > 0; i--){
            $('#menu-' + this.parent.map.layers[i].id).remove();
            this.parent.map.layers[i].destroy();
        }
        this.parent.composition = this.parent.cmpBackUp;
        for (var i = 0; i < this.parent.composition.layers.length; i++){
            var layer = this.parent.composition.layers[i];
            var target =  new OpenLayers.Layer.WMS(
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
            if (target.params.SRS === undefined){ target.params.SRS = this.parent.composition.projection; }
            target.setOpacity(layer.transp);
            target.setVisibility(layer.vis);
            if (layer.style.type === "sld"){
                delete target.params.STYLES;
                target.mergeNewParams({sld_body: layer.style.value.replace(/\\"/gi, '"')}); }
            else { target.mergeNewParams({styles: layer.style.value}); }
            this.parent.map.addLayers([target]);

            this.parent.addLayerToTheList(layer.name, target.id, layer.vis);
        }
    };
}
