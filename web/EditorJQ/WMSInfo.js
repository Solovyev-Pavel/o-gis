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
 *  This objects defines the functions necessary to get the WMS Feature info  *
 * ************************************************************************** */

function CompositionEditorWMSFeatureInfo(){
    this.parent = null;             // parent class
    this.WMSFeatureInfoOn = false;  // keeps track of the WMS Feature Info getter's state
    this.SelectedLayer = null;      // keeps the track of the active layer
    
    // Sets the parent
    this.setParent = function(editor){ this.parent = editor; };
    
    // Activates / deactivates the WMS Feature Info map onclick event
    this.WMSFeatureInfoSwitcher = function(){
        this.WMSFeatureInfoOn = !this.WMSFeatureInfoOn;
        if (this.WMSFeatureInfoOn){
            $('.olfibuttonItemActive').css('background-color', 'rgba(0,10,63,0.6)');
            this.parent.map.events.register('click', this.parent.map, this.WMSFeatureInfoGet);
        }
        else{
            $('.olfibuttonItemActive').css('background-color', 'rgba(0,60,136,0.5)');
            this.parent.map.events.unregister('click', this.parent.map, this.WMSFeatureInfoGet);
        }
    };
    
    // Get the top visible layer from the map
    this.getTopVisibleLayer = function(){
        var list = $('#' + this.parent.params.layerListDOM).children();
        for (var i = 0; i < list.length; i++){
            if (list[i].firstChild.firstChild.checked){ return list[i].getAttribute('id').substring(5); }
        }
        return null;
    };
    
    // Sets a layer as an active one; this layer will be used even if it is not the top one
    this.toggleWMSInfoLayer = function(id){
        var trueid = id.substring(8);
        if (this.SelectedLayer !== trueid){
            if (this.SelectedLayer !== null){ $('#wmsinfo-' + this.SelectedLayer).prop('class', 'notwmsselectedlayer'); }
            this.SelectedLayer = trueid;
            $('#' + id).prop('class', 'wmsselectedlayer');
        }
        else{
            this.SelectedLayer = null;
            $('#' + id).prop('class', 'notwmsselectedlayer');
        }
    };
    
    // Processes the click event on the map
    this.WMSFeatureInfoGet = function(evt){
        var target = (this.parent.WMSFeatureInfo.SelectedLayer !== null) ? this.parent.WMSFeatureInfo.SelectedLayer : this.parent.WMSFeatureInfo.getTopVisibleLayer();
        if (!target){ return; }
        var layer = this.getLayer(target);
        // request url
        var url =   '/o-gis/web/app.php/geoserver/wms?SERVICE=WMS&REQUEST=GetFeatureInfo&EXCEPTIONS=application/vnd.ogc.se_xml&' +
                    'INFO_FORMAT=application/json&BBOX=' + this.getExtent().toBBOX() + '&QUERY_LAYERS=' + 
                    layer.params.LAYERS + '&STYLES=&SRS=' + layer.params.SRS + '&LAYERS=' + layer.params.LAYERS +
                    '&FEATURE_COUNT=10&WIDTH=' + this.size.w + '&HEIGHT=' + this.size.h;
        if (layer.params.VERSION === '1.3.0'){ url += '&VERSION=1.3.0&j=' + parseInt(evt.xy.x) + '&i=' + parseInt(evt.xy.y); }
        else { url += '&VERSION=1.1.1&x=' + parseInt(evt.xy.x) + '&y=' + parseInt(evt.xy.y); }
        var c_map = this;
        OpenLayers.Event.stop(evt);
            $.ajax({ url: url, method: 'GET' })
                .done(function(data){
                    var obj = JSON.parse(data);
                    var info = obj.features;
                    if (info.length === 0){ return; }		// no data
                    else if (info[0].geometry !== null){	// raw data for vectors
                        var type = info[0].geometry.type;
                        var id = info[0].id.substring(info[0].id.indexOf('.') + 1);
                        var text = type + ': ' + id;
                        var width = text.length * 8 + 10;
                        var the_popup = new OpenLayers.Popup('popup', c_map.getLonLatFromPixel(evt.xy), new OpenLayers.Size(width, 20), text, true);
                        the_popup.setBorder('1px solid #157fcc');
                        if (c_map.popups.length > 0){ c_map.popups[0].destroy(); }
                        c_map.addPopup(the_popup);
                    }
                    else{						// raster
                        var text = info[0].properties[Object.keys(info[0].properties)[0]].toString();
                        var width = text.length * 8 + 10;
                        var the_popup = new OpenLayers.Popup('popup', c_map.getLonLatFromPixel(evt.xy), new OpenLayers.Size(width, 20), text, true);
                        the_popup.setBorder('1px solid #157fcc');
                        if (c_map.popups.length > 0){ c_map.popups[0].destroy(); }
                        c_map.addPopup(the_popup);
                    }
            });
    };
}
