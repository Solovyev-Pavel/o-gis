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
 *   This object implements the methods for styling layers displayer in the   *
 *                             composition editor                             *
 *                                                                            *
 *   Dependencies in current realization: SVG, jquery.minicolors.min.js       *
 * ************************************************************************** */

function CompositionEditorLayerStyler(){
    this.parent = null;             // parent class
    this.current_palette = null;    // currently-used raster palette
    this.layerId = '';              // holds the id of the currently-styled layer
    this.layerType = '';            // type of the currently-styled layer;
    
    // Set the parent
    this.setParent = function(editor){ this.parent = editor; };
    
    // Begin styling the layer
    this.styleLayer = function(layer){
        // if styling window is already in use -> return
        if ($('#' + this.parent.params.stylerWindow).dialog('isOpen')){ return; }
        var full_cs = this.parent.map.getLayer(layer.substring(6)).params.LAYERS;
        var cs = full_cs.substring(full_cs.indexOf(':') + 1);
        var type = this.parent.composition.getLayerType(cs);
        // type is already known
        if (type !== undefined && type !== null){
            switch(type){
                case 'raster': this.styleRasterLayer(layer.substring(6)); break;
                case 'point': this.stylePointLayer(layer.substring(6)); break;
                case 'line': this.styleLineLayer(layer.substring(6)); break;
                case 'polygon': this.stylePolygonLayer(layer.substring(6)); break;
            }
        }
        // we need to learn the type of the layer
        else{
            var url = "/o-gis/web/app.php/gettype/layer/" + cs;
            $.ajax(url)
                .done(function(responseText){
                    switch(responseText){
                        case 'raster':  this.parent.compostion.setLayerType(cs, responseText);
                                        this.styleRasterLayer(layer.substring(6)); break;
                        case 'point':   this.parent.compostion.setLayerType(cs, responseText);
                                        this.stylePointLayer(layer.substring(6)); break;
                        case 'line':    this.parent.compostion.setLayerType(cs, responseText);
                                        this.styleLineLayer(layer.substring(6)); break;
                        case 'polygon': this.parent.compostion.setLayerType(cs, responseText);
                                        this.stylePolygonLayer(layer.substring(6)); break;
                    }
                })
                .fail(function(){
                    $('#messagewindow').dialog('option', 'title', 'Error while reading layer data');
                    $('#messagewindow').empty();
                    var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                'Error: could not determine layer type! Styling aborted!</td></tr></table>';
                    $( "#messagewindow" ).append(html);
                    $( "#messagewindow" ).dialog("open");
                });
        }
    };
    
    // Style raster layer
    this.styleRasterLayer = function(_layer){
        var layer = this.parent.map.getLayer(_layer);
        var minMaxNodata = this.parent.composition.getLayerMinMaxNodata(layer.params.LAYERS);
        var opacity = layer.opacity;
        this.layerId = _layer;
        this.layerType = 'raster';
        var html =  '<b>Opacity</b>:<br/><table width="100%"><tr><td width="30px">0%</td><td><div id="opacity-slider"></div></td>' +
                    '<td width="40px" style="text-align:right;">&nbsp;&nbsp;100%</td></tr></table><br/><br/><b>Stylization</b>' +
                    ':<br/><table width="100%"><tr><td width="50%"><label><input type="radio" name="stylingtype" ' +
                    'id="default-styling" onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(false)"';
        if (layer.params.SLD_BODY === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Default Stylization</label></td><td width="49%"><label><input type="radio" name="stylingtype" ' +
                    'id="custom"  onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(true)"';
        if (layer.params.STYLES === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Custom Stylization</label></td></tr></table><br/><div id="advancedmodeoptions"';
        if (layer.params.SLD_BODY === undefined){ html += ' style="display: none"'; }
        html += '><hr/><table width="100%"><tr><td>Selected Palette: <b id="selected-palette-name"></b></td><td width="140px">' +
                '<button type="button" style="width:100%" onclick="' + this.parent.params.thisVar +
                '.LayerStyler.openSelectPaletteWindow();">Select Palette</button></td></tr><tr><td colspan="2">' +
                '<div style="width:100%;height:40px;margin-left:auto;margin-right:auto;display:none;" id="palette-preview-line"></div>' +
                '</td></tr></table><table width="100%"><tr><td width="75px"><input style="width:60px" type="text" id="stretch-min" ' +
                'value="' + minMaxNodata.min + '" onchange="' + this.parent.params.thisVar +
                '.LayerStyler.validateRangeInput(1, this.value, ' + minMaxNodata.min + ')"/></td><td>' +
                '<div id="stretch-slider"></div></td><td width="80px">&nbsp;&nbsp;<input style="width:60px" type="text" ' +
                'id="stretch-max" value="' + minMaxNodata.max + '" onchange="' + this.parent.params.thisVar + 
                '.LayerStyler.validateRangeInput(2, this.value, ' + minMaxNodata.max + ')"/></td></tr><tr><td colspan="3">' +
                '<label><input type="checkbox" id="nodatausage"/>&nbsp;Display NODATA values ' +
                '(<b>' + minMaxNodata.nodata + '</b>) with a visible color</label></td></tr><tr><td colspan="3"><label>' +
                '<input type="checkbox" id="invertorder" />&nbsp;Invert color order</label></td></tr><tr>' +
                '<td colspan="3"><select id="interpolation" style="width:calc(100% - 8px)"><option value="ramp" selected="selected">' +
                'Interpolation: Gradient</option><option value="intervals">Interpolation: Intervals</option><option ' +
                'value="values">Interpolation: Use Palette Values</option></select></td></tr></table></div>';
        $('#' + this.parent.params.stylerWindow).empty().append(html);
        var c_editor = this;
        $('#opacity-slider').slider({   orientation: "horizontal",
                                        range: "min",
                                        min: 0,
                                        max: 1.01,
                                        step: 0.01,
                                        value: opacity,
                                        slide: function(event, ui){ c_editor.setLayerOpacity(_layer, ui.value); }
        });
        var step = (minMaxNodata.max - minMaxNodata.min) / 100;
        $('#stretch-slider').slider({   orientation: "horizontal",
                                        range: true,
                                        min: minMaxNodata.min,
                                        max: minMaxNodata.max,
                                        step: step,
                                        values: [minMaxNodata.min, minMaxNodata.max],
                                        slide: function(event, ui){ c_editor.validateRangeInput(3, ui.values, null); }
        });

        // the order of params for palette:
        // id -> min -> max -> NODATA usage -> color order inversion
        // e.g. 2 -7.5 31 0 1
        // color interpolation type can be taken from the style itself
        this.current_palette = null;
        
        // load previously-defined custom style
        if (layer.params.SLD_BODY !== undefined){
            var xmlDoc;
            if (window.DOMParser) {
                var parser = new DOMParser();
                xmlDoc = parser.parseFromString(layer.params.SLD_BODY, 'text/xml');
            }
            else {
                xmlDoc = new ActiveXObject('Microsoft.XMLDOM');
                xmlDoc.async = false;
                xmlDoc.loadXML(layer.params.SLD_BODY);
            }

            var abstract = xmlDoc.getElementsByTagName('Abstract');
            var cmap = xmlDoc.getElementsByTagName('ColorMap')[0].getAttributeNode('type').nodeValue;
            var params = abstract[0].textContent.split(' ');

            // ignore old versions
            if (params.length === 5){        
                getSelectedPalette(params[0], 'Layer palette');
                $('#stretch-min').prop('value', params[1]);
                $('#stretch-max').prop('value', params[2]);
                $('#stretch-slider').slider('values', 0, params[1]);
                $('#stretch-slider').slider('values', 1, params[2]);
                if (parseInt(params[3]) === 1){ $('#nodatausage').prop('checked', 'checked'); }
                if (parseInt(params[4]) === 1){ $('#invertorder').prop('checked', 'checked'); }

                var dd = document.getElementById('interpolation');
                for (var i = 0; i < dd.options.length; i++) {
                    if (dd.options[i].value === cmap) {
                        dd.value = cmap;
                        break;
                    }
                }
            }
        }

        $('#' + this.parent.params.stylerWindow).dialog('open');
    };
    
    // Opens the window with the list of palettes
    this.openSelectPaletteWindow = function(){
        if ($('#' + this.parent.params.selectPaletteWindow).children().length === 0){
            $('#' + this.parent.params.selectPaletteWindow).append('<iframe width="95%" height="95%" src="' + paletteListRoute + '">');
        }
        $('#' + this.parent.params.selectPaletteWindow).dialog("open");
    };
    
    // Get the palette picked by the user
    this.getSelectedPalette = function(palette_id, name){
        $.ajax(getPaletteRoute.replace('ID', palette_id))
            .done(function(msg){
                if (!msg.success){
                    $( '#messagewindow' ).dialog('option', 'title', 'Error!');
                    var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                'Error while loading palette <b>' + name + '</b>: ' + msg.message + '</td></tr></table>';
                    $( "#messagewindow" ).empty().append(html);
                    $( "#messagewindow" ).dialog("open");
                    return;
                }
                this.current_palette = msg;
                $('#selected-palette-name').empty().append(msg.name);
                var svg_background =    '<svg width="100%" height="100%"><defs><linearGradient id="paletteGradient" ' +
                                        'x1="0%" y1="0%" x2="100%" y2="0%">';
                for (var i = 0; i < msg.colors.length; i++){
                    svg_background +=   '<stop offset="' + parseInt(msg.locations[i] * 100) + '%" style="stop-color:#' + 
                                        msg.colors[i].rgb.substring(2) + ';stop-opacity:' + msg.colors[i].opacity + '" />';
                }
                svg_background += '</linearGradient></defs><rect width="470" height="40" fill="url(#paletteGradient)" /></svg>';
                $('#palette-preview-line').css('display', 'block');
                $('#palette-preview-line').empty().append(svg_background);
                if ($('#' + this.parent.params.selectPaletteWindow).dialog('isOpen')){
                    $('#' + this.parent.params.selectPaletteWindow).dialog('close');
                }
            })
            .fail(function(){
                $( '#messagewindow' ).dialog('option', 'title', 'Error!');
                var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                            'Error while loading palette <b>' + name + '</b>.</td></tr></table>';
                $( "#messagewindow" ).empty().append(html);
                $( "#messagewindow" ).dialog("open");
            });
    };
    
    // Style point vector layer
    this.stylePointLayer = function(_layer){
        var layer = this.parent.map.getLayer(_layer);
        var opacity = layer.opacity;
        this.layerId = _layer;
        this.layerType = 'point';
        var html =  '<b>Opacity</b>:<br/><table width="100%"><tr><td width="30px">0%</td><td><div id="opacity-slider"></div></td>' +
                    '<td width="40px" style="text-align:right;">&nbsp;&nbsp;100%</td></tr></table><br/><br/><b>Stylization</b>:<br/>' +
                    '<table width="100%"><tr><td width="50%"><label><input type="radio" name="stylingtype" id="default-styling"' +
                    ' onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(false)"';
        if (layer.params.SLD_BODY === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Default Stylization</label></td><td width="49%"><label><input type="radio" name="stylingtype" ' +
                    'id="custom"  onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(true)"';
        if (layer.params.STYLES === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Custom Stylization</label></td></tr></table><br/><div id="advancedmodeoptions"';
        if (layer.params.SLD_BODY === undefined){ html += ' style="display: none"'; }
        html += '><hr/><table width="100%"><tr><th width="220px"><center><b>Point</b>:</center></th><th width="220px"><center>' +
                '<b>Contour</b>:</center></th><th width="110px"><center><b>Preivew</b>:</center></th></tr><tr>' +
                '<td><select id="point-type" style="width:195px;"><option value="0">Shape: Circle</option><option value="1">' +
                'Shape: Square</option><option value="2">Shape: Triangle</option><option value="3">Shape: Rhombus</option>' +
                '</select></td><td><label><input id="point-contour" type="checkbox" onchange="' + this.parent.params.thisVar +
                '.LayerStyler.updatePoint()" checked="checked"/>Draw contour</label></td><td rowspan="3">' +
                '<div style="width:105px;height:210px" id="style-preview-box"></div></td></tr><tr><td><input id="point-size" ' +
                'style="width:145px;" value="12"/>&nbsp;px</td><td></td></tr><tr><td><input type="text" id="colorpicker-fill" ' +
                'data-opacity="1" value="#ff0000" /></td><td><input type="text" id="colorpicker-contour" data-opacity="1" ' +
                'value="#000000" /></td></tr></table>';

        $('#' + this.parent.params.stylerWindow).empty().append(html);
        var c_editor = this;
        $('#opacity-slider').slider({   orientation: "horizontal",
                                        range: "min",
                                        min: 0,
                                        max: 1.01,
                                        step: 0.01,
                                        value: opacity,
                                        slide: function(event, ui){ c_editor.setLayerOpacity(_layer, ui.value); }
        });

        $('#point-type').selectmenu({ change: function(event, data){ c_editor.updatePoint(); } });
        $('#point-size').spinner({ spin: function(event, ui){
                                    c_editor.updatePoint();
                                    if (ui.value < 7){ $(this).spinner("value", 7); return false; }
                                    if (ui.value > 20){ $(this).spinner("value", 20); return false;  }
        }});

        $('#colorpicker-fill').minicolors({
                                    control: 'hue',
                                    defaultValue: '',
                                    inline: true,
                                    letterCase: 'lowercase',
                                    opacity: true,
                                    position: $(this).attr('data-position') || 'bottom left',
                                    change: function(hex, opacity) { c_editor.updatePoint(); },
                                    theme: 'bootstrap'
                                });
        $('#colorpicker-contour').minicolors({
                                    control: 'hue',
                                    defaultValue: '',
                                    inline: true,
                                    letterCase: 'lowercase',
                                    opacity: true,
                                    position: $(this).attr('data-position') || 'bottom left',
                                    change: function(hex, opacity) { c_editor.updatePoint(); },
                                    theme: 'bootstrap'
                                });

        // if the layer has previously-defined custom styling
        if (layer.params.SLD_BODY !== undefined){
            var xmlDoc;
            if (window.DOMParser) {
                var parser = new DOMParser();
                xmlDoc = parser.parseFromString(layer.params.SLD_BODY, "text/xml");
            }
            else {
                xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                xmlDoc.async = false;
                xmlDoc.loadXML(layer.params.SLD_BODY);
            }

            var params = xmlDoc.getElementsByTagName("CssParameter");
            var has_contour = (xmlDoc.getElementsByTagName("Stroke").length !== 0) ? true : false;
            if (has_contour){ $('#point-contour').prop('checked', true); }
            else{ $('#point-contour').prop('checked', false); }
            var shape = (xmlDoc.getElementsByTagName("Rotation").length !== 0) ? 'rhombus' : xmlDoc.getElementsByTagName("WellKnownName")[0].textContent;
            var shape_id = 0;
            switch(shape){
                case 'circle': shape_id = 0; break;
                case 'square': shape_id = 1; break;
                case 'triangle': shape_id = 2; break;
                case 'rhombus': shape_id = 3; break;
            }
            $('#point-type').val(shape_id).selectmenu('refresh');
            $('#point-size').val(xmlDoc.getElementsByTagName("Size")[0].textContent);
            var color = params[0].textContent.substring(2);
            $('#colorpicker-fill').minicolors('value', '#' + color);
            $('#colorpicker-fill').minicolors('opacity', params[1].textContent);
            var color = params[2].textContent.substring(2);
            $('#colorpicker-contour').minicolors('value', '#' + color);
            $('#colorpicker-contour').minicolors('opacity', params[4].textContent);
        }

        this.updatePoint();
        $('#' + this.parent.params.stylerWindow).dialog("open");
    };
    
    // Updates point-preview
    this.updatePoint = function(){
        var fill_color = {
            rgb: $('#colorpicker-fill').prop('value'),
            a: document.getElementById('colorpicker-fill').getAttribute('data-opacity'),
            rgba: $('#colorpicker-fill').minicolors('rgbaString')
        };
        var ctr_color = {
            rgb: $('#colorpicker-contour').prop('value'),
            a: document.getElementById('colorpicker-contour').getAttribute('data-opacity'),
            rgba: $('#colorpicker-contour').minicolors('rgbaString')
        };

        var type = parseInt($('#point-type').val());
        var size = parseInt($('#point-size').val());
        var ctr = $('#point-contour').prop('checked');
        if (!ctr){ ctr_color = fill_color; }
        var svg = '<svg height="210px" width="105px">';
        switch (type){
            case 0: svg +=  '<circle cx="30" cy="30" r="' + (size / 2) + '" stroke="' + ctr_color.rgba +
                            '" stroke-width="1" fill="' + fill_color.rgba + '" />' +
                            '<circle cx="70" cy="100" r="' + (size / 2) + '" stroke="' + ctr_color.rgba +
                            '" stroke-width="1" fill="' + fill_color.rgba + '" />' +
                            '<circle cx="40" cy="170" r="' + (size / 2) + '" stroke="' + ctr_color.rgba +
                            '" stroke-width="1" fill="' + fill_color.rgba + '" />'  ;
                    break;
            case 1: svg +=  '<rect width="' + size + '" height="' + size + '" x="' + (30 - size / 2) +
                            '" y="' + (30 - size / 2) + '" stroke="' + ctr_color.rgba + '" stroke-width="1" ' +
                            'fill="' + fill_color.rgba + '" />' +
                            '<rect width="' + size + '" height="' + size + '" x="' + (70 - size / 2) +
                            '" y="' + (100 - size / 2) + '" stroke="' + ctr_color.rgba + '" stroke-width="1" ' +
                            'fill="' + fill_color.rgba + '" />' +
                            '<rect width="' + size + '" height="' + size + '" x="' + (40 - size / 2) +
                            '" y="' + (170 - size / 2) + '" stroke="' + ctr_color.rgba + '" stroke-width="1" ' +
                            'fill="' + fill_color.rgba + '" />';
                    break;
            case 2: svg +=  '<polygon points="30,' + (30 - 2 * size / 3) + ' ' + (30 + size / 2) + ',' +
                            (30 + size / 3) + ' ' + (30 - size / 2) + ',' + (30 + size / 3) + '" style="fill:' +
                            fill_color.rgba + ';stroke-width:1;stroke:' + ctr_color.rgba + '" />' +
                            '<polygon points="70,' + (100 - 2 * size / 3) + ' ' + (70 + size / 2) + ',' +
                            (100 + size / 3) + ' ' + (70 - size / 2) + ',' + (100 + size / 3) + '" style="fill:' +
                            fill_color.rgba + ';stroke-width:1;stroke:' + ctr_color.rgba + '" />' +
                            '<polygon points="40,' + (170 - 2 * size / 3) + ' ' + (40 + size / 2) + ',' +
                            (170 + size / 3) + ' ' + (40 - size / 2) + ',' + (170 + size / 3) + '" style="fill:' +
                            fill_color.rgba + ';stroke-width:1;stroke:' + ctr_color.rgba + '" />';
                    break;
            case 3: svg +=  '<polygon points="30,' + (30 - size / 2) + ' ' + (30 + size / 2) + ',30 30,' + 
                            (30 + size / 2) + ' ' + (30 - size / 2) + ',30" style="fill:' + fill_color.rgba +
                            ';stroke-width:1;stroke:' + ctr_color.rgba + '" />' +
                            '<polygon points="70,' + (100 - size / 2) + ' ' + (70 + size / 2) + ',100 70,' + 
                            (100 + size / 2) + ' ' + (70 - size / 2) + ',100" style="fill:' + fill_color.rgba +
                            ';stroke-width:1;stroke:' + ctr_color.rgba + '" />' +
                            '<polygon points="40,' + (170 - size / 2) + ' ' + (40 + size / 2) + ',170 40,' + 
                            (170 + size / 2) + ' ' + (40 - size / 2) + ',170" style="fill:' + fill_color.rgba +
                            ';stroke-width:1;stroke:' + ctr_color.rgba + '" />';
                    break;
        }
        svg += '</svg>';
        $('#style-preview-box').empty().append(svg);
    };
    
    // Style line vector layer
    this.styleLineLayer = function(_layer){
        var layer = this.parent.map.getLayer(_layer);
        var opacity = layer.opacity;
        this.layerId = _layer;
        this.layerType = 'line';
        var html =  '<b>Opacity</b>:<br/><table width="100%"><tr><td width="30px">0%</td><td><div id="opacity-slider"></div></td>' +
                    '<td width="40px" style="text-align:right;">&nbsp;&nbsp;100%</td></tr></table><br/><br/><b>Stylization</b>:<br/>' +
                    '<table width="100%"><tr><td width="50%"><label><input type="radio" name="stylingtype" id="default-styling"' +
                    ' onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(false)"';
        if (layer.params.SLD_BODY === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Default Stylization</label></td><td width="49%"><label><input type="radio" name="stylingtype" ' +
                    'id="custom"  onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(true)"';
        if (layer.params.STYLES === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Custom Stylization</label></td></tr></table><br/><div id="advancedmodeoptions"';
        if (layer.params.SLD_BODY === undefined){ html += ' style="display: none"'; }
        html += '><hr/><table width="100%"><tr><th width="220px"><center><b>Line type</b>:</center></th><th width="220px"><center>' +
                '<b>Line color</b>:</center></th><th width="110px"><center><b>Preview</b>:</center></th></tr><tr height="30px">' +
                '<td valign="top"><select id="line-type" style="width:200px;"><option value="0">Solid line</option><option ' +
                'value="1">Dashed line</option></select></td><td valign="top" rowspan="2"><input type="text" id="colorpicker-contour" ' +
                'data-opacity="1" value="#000000" /></td><td rowspan="2"><div id="style-preview-box" ' +
                'style="width:105px;height:170px;"></div></td></tr><tr><td valign="top"><input id="line-width" style="width:145px;" ' +
                'value="1"/>&nbsp;px</td></tr></table>';

        $('#' + this.parent.params.stylerWindow).empty().append(html);
        var c_editor = this;
        $('#opacity-slider').slider({   orientation: "horizontal",
                                        range: "min",
                                        min: 0,
                                        max: 1.01,
                                        step: 0.01,
                                        value: opacity,
                                        slide: function(event, ui){ c_editor.setLayerOpacity(_layer, ui.value); }
        });

        $('#line-type').selectmenu({ change: function(event, data){ c_editor.updateLine(); } });
        $('#line-width').spinner({ spin: function(event, ui){
                                        if (ui.value < 1){ $(this).spinner("value", 1); return false; }
                                        if (ui.value > 6){ $(this).spinner("value", 6); return false; }
                                        $(this).spinner("value", ui.value);
                                        c_editor.updateLine();
        }});

        $('#colorpicker-contour').minicolors({
                                    control: 'hue',
                                    defaultValue: '',
                                    inline: true,
                                    letterCase: 'lowercase',
                                    opacity: true,
                                    position: $(this).attr('data-position') || 'bottom left',
                                    change: function(hex, opacity) { c_editor.updateLine(); },
                                    theme: 'bootstrap'
                                });

        // if layer has previously-defined custom style
        if (layer.params.SLD_BODY !== undefined){
            var xmlDoc;
            if (window.DOMParser) {
                var parser = new DOMParser();
                xmlDoc = parser.parseFromString(layer.params.SLD_BODY, "text/xml");
            }
            else {
                xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                xmlDoc.async = false;
                xmlDoc.loadXML(layer.params.SLD_BODY);
            }

            var params = xmlDoc.getElementsByTagName("CssParameter");
            var color = params[0].textContent.substring(2);
            $('#colorpicker-contour').minicolors('value', '#' + color);
            $('#colorpicker-contour').minicolors('opacity', params[2].textContent);
            $('#line-width').val(parseInt(params[1].textContent) + 1);
            if (params.length === 4){ $('#line-type').val(1).selectmenu('refresh'); }
        }
        this.updateLine();

        $('#' + this.parent.params.stylerWindow).dialog("open");
    };
    
    // Update line-preview
    this.updateLine = function(){
        var type = parseInt($('#line-type').val());
        var width = parseInt($('#line-width').spinner('value'));
        var color = {
            rgb: $('#colorpicker-contour').prop('value'),
            a: document.getElementById('colorpicker-contour').getAttribute('data-opacity'),
            rgba: $('#colorpicker-contour').minicolors('rgbaString')
        };
        if (type !== 1){ var sda = 'none'; }
        else{ var sda = '5,5'; }
        var svg =   '<svg height="170px" width="105px"><path id="curve" style="fill:none;" d="M 5 5 q 165 80 5 160" ' +
                    'stroke="' + color.rgba + '" stroke-width="' +  (width - 0.5) + '" stroke-dasharray="' + sda + '" /></svg>';
        $('#style-preview-box').empty().append(svg);
    };
    
    // Style polygon vector layer
    this.stylePolygonLayer = function(_layer){
        var layer = this.parent.map.getLayer(_layer);
        var opacity = layer.opacity;
        this.layerId = _layer;
        this.layerType = 'polygon';
        var html =  '<b>Opacity</b>:<br/><table width="100%"><tr><td width="30px">0%</td><td><div id="opacity-slider"></div></td>' +
                    '<td width="40px" style="text-align:right;">&nbsp;&nbsp;100%</td></tr></table><br/><br/><b>Stylization</b>:<br/>' +
                    '<table width="100%"><tr><td width="50%"><label><input type="radio" name="stylingtype" id="default-styling"' +
                    ' onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(false)"';
        if (layer.params.SLD_BODY === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Default Stylization</label></td><td width="49%"><label><input type="radio" name="stylingtype" ' +
                    'id="custom"  onchange="' + this.parent.params.thisVar + '.LayerStyler.setPaletteToolsVisibility(true)"';
        if (layer.params.STYLES === undefined){ html += ' checked="checked"'; }
        html +=     '/>&nbsp;&nbsp;Custom Stylization</label></td></tr></table><br/><div id="advancedmodeoptions"';
        if (layer.params.SLD_BODY === undefined){ html += ' style="display: none"'; }
        html += '><hr/><table width="100%"><tr><th width="220px"><center><b>Polygon fill</b>:</center></th><th width="220px">' +
                '<center><b>Polygon contour</b>:</center></th><th width="110px"><center><b>Preview</b>:</center></th></tr><tr>' +
                '<td><select id="fill-type" style="width:200px;"><option value="0">Flood fill</option><option value="1">' +
                'Dashes right</option><option value="2">Dashes left</option></select></td><td><select id="contour-type" ' +
                'style="width:200px;"><option value="0">Solid line</option><option value="1">Dashed line</option></select></td>' +
                '<td rowspan="3"><div id="style-preview-box" style="width:105px;height:220px"></div></td></tr><tr><td>&nbsp;</td>' +
                '<td><input id="contour-width" style="width:145px;" value="1"/>&nbsp;px</td></tr><tr><td><input type="text" ' +
                'id="colorpicker-fill" data-opacity="0.4" value="#8f8f8f" /></td><td><input type="text" id="colorpicker-contour" ' +
                'data-opacity="1" value="#000000" /></td></tr></table></div>';

        $('#' + this.parent.params.stylerWindow).empty().append(html);
        var c_editor = this;
        $('#opacity-slider').slider({   orientation: "horizontal",
                                        range: "min",
                                        min: 0,
                                        max: 1.01,
                                        step: 0.01,
                                        value: opacity,
                                        slide: function(event, ui){ c_editor.setLayerOpacity(_layer, ui.value); }
        });

        $('#fill-type').selectmenu({ change: function(event, data){ c_editor.updatePolygon(); } });
        $('#contour-type').selectmenu({ change: function(event, data){ c_editor.updatePolygon(); } });
        $('#contour-width').spinner({ spin: function(event, ui){
                                        if (ui.value < 1){ $(this).spinner("value", 1); return false; }
                                        if (ui.value > 6){ $(this).spinner("value", 6); return false; }
                                        $(this).spinner("value", ui.value);
                                        c_editor.updatePolygon();
        }});

        $('#colorpicker-fill').minicolors({
                                    control: 'hue',
                                    defaultValue: '',
                                    inline: true,
                                    letterCase: 'lowercase',
                                    opacity: true,
                                    position: $(this).attr('data-position') || 'bottom left',
                                    change: function(hex, opacity) { c_editor.updatePolygon(); },
                                    theme: 'bootstrap'
                                });
        $('#colorpicker-contour').minicolors({
                                    control: 'hue',
                                    defaultValue: '',
                                    inline: true,
                                    letterCase: 'lowercase',
                                    opacity: true,
                                    position: $(this).attr('data-position') || 'bottom left',
                                    change: function(hex, opacity) { c_editor.updatePolygon(); },
                                    theme: 'bootstrap'
                                });

        // if the layer has previously-defined custom style
        if (layer.params.SLD_BODY !== undefined){
            var xmlDoc;
            if (window.DOMParser) {
                var parser = new DOMParser();
                xmlDoc = parser.parseFromString(layer.params.SLD_BODY, "text/xml");
            }
            else {
                xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
                xmlDoc.async = false;
                xmlDoc.loadXML(layer.params.SLD_BODY);
            }

            var fill_type = xmlDoc.getElementsByTagName("WellKnownName");
            var i;
            if (typeof(fill_type[0]) === 'undefined'){
                i = 0;
                $('#fill-type').val(0).selectmenu('refresh');
                var fill_params = xmlDoc.getElementsByTagName("Fill")[0];
                var color = fill_params.childNodes[0].textContent.substring(2);
                $('#colorpicker-fill').minicolors('value', '#' + color);
                $('#colorpicker-fill').minicolors('opacity', fill_params.childNodes[1].textContent);
            }
            else {
                i = 1;
                switch(fill_type[0].textContent){
                    case 'shape://slash':       $('#fill-type').val(1).selectmenu('refresh'); break;
                    case 'shape://backslash':   $('#fill-type').val(2).selectmenu('refresh'); break;
                }
                var fill_params = fill_type[0].nextSibling;
                var color = fill_params.childNodes[0].textContent.substring(2);
                $('#colorpicker-fill').minicolors('value', '#' + color);
                $('#colorpicker-fill').minicolors('opacity', fill_params.childNodes[1].textContent);
            }
            var border_params = xmlDoc.getElementsByTagName("Stroke")[i];
            var color = border_params.childNodes[0].textContent.substring(2);
            $('#colorpicker-contour').minicolors('value', '#' + color);
            $('#colorpicker-contour').minicolors('opacity', border_params.childNodes[1].textContent);
            $('#contour-width').val(parseInt(border_params.childNodes[2].textContent) + 1);
            if (border_params.childNodes.length === 4){  $('#contour-type').val(1).selectmenu('refresh'); }
        }

        this.updatePolygon();
        $('#' + this.parent.params.stylerWindow).dialog("open");
    };
    
    // Update polygon-preview
    this.updatePolygon = function(){
        var fill_type = parseInt($('#fill-type').val());
        var ctr_type = parseInt($('#contour-type').val());
        var ctr_width = parseInt($('#contour-width').val());
        var fill_color = {
            rgb: $('#colorpicker-fill').prop('value'),
            a: document.getElementById('colorpicker-fill').getAttribute('data-opacity'),
            rgba: $('#colorpicker-fill').minicolors('rgbaString')
        };
        var ctr_color = {
            rgb: $('#colorpicker-contour').prop('value'),
            a: document.getElementById('colorpicker-contour').getAttribute('data-opacity'),
            rgba: $('#colorpicker-contour').minicolors('rgbaString')
        };

        if (ctr_type === 0){ var sda = 'none'; }
        else{ var sda = '5,5'; }

        var svg =   '<svg height="220px" width="105px">';
        switch(fill_type){
            case 0: svg +=  '<path d="M 5 5 L 95 40 L 70 105 L 90 195 L 30 160 Z" ' + 'fill="' + fill_color.rgba + '" stroke="' + 
                            ctr_color.rgba + '" stroke-width="' + (ctr_width - 0.5) + '" stroke-dasharray="' + sda + '">';
                    break;
            case 1: svg +=  '<defs><pattern id="previewPolygonFill" x="0" y="0" width="10" height="15" patternUnits="userSpaceOnUse"' +
                            'patternTransform="rotate(45)"><rect width="2" height="20" fill="' + fill_color.rgba +'" transform="' +
                            'translate(0,0)"></pattern></defs><path d="M 5 5 L 95 40 L 70 105 L 90 195 L 30 160 Z" ' + 
                            'fill="url(#previewPolygonFill)" stroke="' + ctr_color.rgba + '" stroke-width="' + (ctr_width - 0.5) +
                            '" stroke-dasharray="' + sda + '"></svg>';
                    break;
            case 2: svg +=  '<defs><pattern id="previewPolygonFill" x="0" y="0" width="10" height="15" patternUnits="userSpaceOnUse"' +
                            'patternTransform="rotate(135)"><rect width="2" height="20" fill="' + fill_color.rgba +'" transform="' +
                            'translate(0,0)"></pattern></defs><path d="M 5 5 L 95 40 L 70 105 L 90 195 L 30 160 Z" ' + 
                            'fill="url(#previewPolygonFill)" stroke="' + ctr_color.rgba + '" stroke-width="' + (ctr_width - 0.5) +
                            '" stroke-dasharray="' + sda + '"></svg>';
                    break;
        }
        $('#style-preview-box').empty().append(svg);
    };
    
    // Switch between basic and advanced styler window
    this.setPaletteToolsVisibility = function(is_advanced){
        if(is_advanced){    $('#advancedmodeoptions').css('display', 'block'); }
        else{               $('#advancedmodeoptions').css('display', 'none');  }
    };
    
    // Validates ranges for raster palette strentching
    this.validateRangeInput = function(source, value, edge){
        if (source === 1){
            if (value < edge){ value = edge; }
            if (value > $('#stretch-slider').slider('values', 1)){
                value = $('#stretch-slider').slider('values', 1) - $('#stretch-slider').slider('option', 'step');
            }
            $('#stretch-min').prop('value', value);
            $('#stretch-slider').slider('values', 0, value);
        }
        if (source === 2){
            if (value > edge){ value = edge; }
            if (value < $('#stretch-slider').slider('values', 0)){
                value = $('#stretch-slider').slider('values', 0) + $('#stretch-slider').slider('option', 'step');
            }
            $('#stretch-max').prop('value', value);
            $('#stretch-slider').slider('values', 1, value);
        }
        if (source === 3){
            $('#stretch-min').prop('value', value[0]);
            $('#stretch-max').prop('value', value[1]);
        }
    };
    
    // Sets layer's styling to its default value
    this.resetLayerStyling = function(layer_id){
        var layer = this.parent.map.getLayer(layer_id);
        if (layer.params.SLD_BODY !== undefined){
            delete layer.params.SLD_BODY;
            layer.mergeNewParams({STYLES: ""});
        }
        else { layer.params.STYLES = ""; }
        layer.redraw();
    };
    
    // Sets the opacity of the currently-styled layer
    this.setLayerOpacity = function(layer, value){
        this.parent.map.getLayer(layer).setOpacity(value);
    };
    
    // Apply selected styling to the layer
    this.applyLayerStyling = function(){
        if($('#default-styling').prop('checked') === true){
            this.resetLayerStyling(this.layerId);
            return;
        }
        var layer = this.parent.map.getLayer(this.layerId);
        var sld =   '<StyledLayerDescriptor version="1.0.0" xmlns="http://www.opengis.net/sld" xmlns:ogc="http://www.opengis.net/ogc">' +
                    '<NamedLayer><Name>' + layer.params.LAYERS + '</Name><UserStyle><FeatureTypeStyle>';
        switch(this.layerType){
            case 'raster':  // make sure that a palette is selected
                            if (this.current_palette === null){
                                $( '#messagewindow' ).dialog('option', 'title', 'Error!');
                                var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                            'You must choose a palette!</td></tr></table>';
                                $( "#messagewindow" ).empty().append(html);
                                $( "#messagewindow" ).dialog("open");
                                return;
                            }
                            var min = parseFloat($('#stretch-min').val());
                            var max = parseFloat($('#stretch-max').val());
                            var ndt_usage = ($('#nodatausage').prop('checked')) ? 1 : 0;
                            var inv_order = ($('#invertorder').prop('checked')) ? 1 : 0;
                            var interpolation = document.getElementById("interpolation").value;
                            var diff = max - min;
                            var minmaxnodata = this.parent.composition.getLayerMinMaxNodata(layer.params.LAYERS);
                            var j = (inv_order === 1) ? this.current_palette.colors.length - 1 : 0;
                            sld +=  '<Rule><Abstract>' + this.current_palette.id + ' ' + min + ' ' + max + ' ' + ndt_usage + ' ' +
                                    inv_order + '</Abstract><RasterSymbolizer><ColorMap type="' + interpolation + '" extended="true">';
                            if (interpolation !== 'values' && ndt_usage === 0){
                                sld += '<ColorMapEntry color="0x000000" quantity="' + minmaxnodata.nodata + '" opacity="0"/>';
                                if (interpolation === 'intervals'){
                                    sld += '<ColorMapEntry color="0x000000" quantity="' + (parseFloat(minmaxnodata.nodata) + 0.000001) +
                                            '" opacity="0"/>';
                                }
                            }
                            else{
                                sld +=  '<ColorMapEntry color="' + this.current_palette.colors[j].rgb + '" quantity="' +
                                        minmaxnodata.nodata + '" opacity="' + this.current_palette.colors[j].opacity + '"/>';
                            }
                            for(var i = 0; i < this.current_palette.colors.length; i++){
                                j = (inv_order === 1) ? this.current_palette.colors.length - 1 - i : i;
                                if (interpolation === 'values'){
                                    sld +=  '<ColorMapEntry color="' + this.current_palette.colors[j].rgb + '" quantity="' + 
                                            this.current_palette.colors[i].pos + '" opacity="' +
                                            this.current_palette.colors[j].opacity + '" />';
                                }
                                else {
                                    sld +=  '<ColorMapEntry color="' + this.current_palette.colors[j].rgb + '" quantity="' +
                                            (parseFloat(min) + parseFloat(diff) * parseFloat(this.current_palette.locations[i])).toFixed(3) +
                                            '" opacity="' + this.current_palette.colors[j].opacity + '" />';
                                }
                            }
                            sld += '</ColorMap></RasterSymbolizer></Rule>';
                            break;
            case 'point':   var size = $('#point-size').val();
                            var shape = parseInt($('#point-type').val());
                            var mainColor = $('#colorpicker-fill').prop('value').replace('#', '0x');
                            var ctrColor = $('#colorpicker-contour').prop('value').replace('#', '0x');
                            var mainOpacity = document.getElementById('colorpicker-fill').getAttribute('data-opacity');
                            var ctrOpacity = document.getElementById('colorpicker-contour').getAttribute('data-opacity');
                            var shape_verb = '';
                            switch(shape){
                                case 0: shape_verb = 'circle'; break;
                                case 1: shape_verb = 'square'; break;
                                case 2: shape_verb = 'triangle'; break;
                                case 3: shape_verb = 'square'; break;
                            }
                            sld +=  '<Rule><PointSymbolizer><Graphic><Mark><WellKnownName>' + shape_verb + '</WellKnownName><Fill>' +
                                    '<CssParameter name="fill">' + mainColor + '</CssParameter><CssParameter name="fill-opacity">' +
                                    mainOpacity + '</CssParameter></Fill>';
                            if ($('#point-contour').prop('checked')){
                                sld +=  '<Stroke><CssParameter name="stroke">' + ctrColor + '</CssParameter><CssParameter ' +
                                        'name="stroke-width">0</CssParameter><CssParameter name="stroke-opacity">' + ctrOpacity +
                                        '</CssParameter></Stroke>';
                            }
                            sld += '</Mark><Size>' + size + '</Size>';
                            if (shape === 3){ sld += '<Rotation>45</Rotation>'; }
                            sld += '</Graphic></PointSymbolizer></Rule>';
                            break;
            case 'line':    var color = $('#colorpicker-contour').prop('value').replace('#', '0x');
                            var opacity = document.getElementById('colorpicker-contour').getAttribute('data-opacity');
                            var type = parseInt($('#line-type').val());
                            var width = parseInt($('#line-width').val()) - 1;
                            sld +=  '<Rule><LineSymbolizer><Stroke><CssParameter name="stroke">' + color + '</CssParameter>' +
                                    '<CssParameter name="stroke-width">' + width + '</CssParameter><CssParameter name="stroke-opacity">' +
                                    opacity + '</CssParameter>';
                            if (type === 1){ sld += '<CssParameter name="stroke-dasharray">5 3</CssParameter>'; }
                            sld += '</Stroke></LineSymbolizer></Rule>';
                            break;
            case 'polygon': var bkgColor = $('#colorpicker-fill').prop('value').replace('#', '0x');
                            var ctrColor = $('#colorpicker-contour').prop('value').replace('#', '0x');
                            var bkgOpacity = document.getElementById('colorpicker-fill').getAttribute('data-opacity');
                            var ctrOpacity = document.getElementById('colorpicker-contour').getAttribute('data-opacity');
                            var fillType = parseInt($('#fill-type').val());
                            var ctrType = parseInt($('#contour-type').val());
                            var ctrWidth = parseInt($('#contour-width').val()) - 1;
                            sld += '<Rule><PolygonSymbolizer><Fill>';
                            if (fillType === 0){
                                sld += '<CssParameter name="fill">' + bkgColor + '</CssParameter><CssParameter name="fill-opacity">' + bkgOpacity + '</CssParameter>';
                            }
                            else{
                                sld += '<GraphicFill><Graphic><Mark><WellKnownName>shape:';
                                if (fillType === 1){ sld+= '//slash'; }
                                else { sld += '//backslash'; }
                                sld +=  '</WellKnownName><Stroke><CssParameter name="stroke">' + bkgColor + '</CssParameter><CssParameter name="stroke-width">' +
                                        '2</CssParameter><CssParameter name="stroke-opacity">' + bkgOpacity + '</CssParameter></Stroke></Mark>' +
                                        '<Size>16</Size></Graphic></GraphicFill>';
                            }
                            sld +=  '</Fill><Stroke><CssParameter name="stroke">' + ctrColor + '</CssParameter><CssParameter name="stroke-opacity">' +
                                    ctrOpacity + '</CssParameter><CssParameter name="stroke-width">' + ctrWidth + '</CssParameter>';
                            if (ctrType === 1){
                                sld += '<CssParameter name="stroke-dasharray">5 2</CssParameter>';
                            }
                            sld += '</Stroke></PolygonSymbolizer></Rule>';
                            break;
        }
        sld += '</FeatureTypeStyle></UserStyle></NamedLayer></StyledLayerDescriptor>';
        if (layer.params.SLD_BODY === undefined){
            delete layer.params.STYLES;
        }
        layer.mergeNewParams({sld_body: sld});
        layer.redraw();
    };
    
    // Converts three numbers into hex rgb
    this.to_rgb = function(red, green, blue, prefix){
        var color = prefix;
        red = parseInt(red).toString(16);
        if (red.length === 1){ red = '0' + red;}
        green = parseInt(green).toString(16);
        if (green.length === 1){ green = '0' + green;}
        blue = parseInt(blue).toString(16);
        if (blue.length === 1){ blue = '0' + blue;}
        color += red + green + blue;
        return color;
    };
}
