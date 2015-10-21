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
 *  ************************************************************************* */

function PaletteEditor(){
    this.default_grid_dom   = "palette-editor-container";
    this.actual_grid_dom    = null;
    this.default_grid_class = "palette-editor-cell";
    this.default_grid_color = "rgba(255, 255, 255, 1)";
    this.grid_cell_onclick  = null;
    this.version            = '0.1a';
    
    this.getVersion = function(){
        return "GIS Palette Editor, version " + this.version;
    };
    
    this.setGridCellOnclickFunction = function(f_name){
        this.grid_cell_onclick = f_name;
    };
    
    this.generateGrid = function(target_dom, css_class){
        if (target_dom === undefined || target_dom === null || target_dom.match(/^\s*$/)){
            this.actual_grid_dom = this.default_grid_dom;
        }
        else{
            this.actual_grid_dom = target_dom;
        }
        if (css_class === undefined || css_class === null || css_class.match(/^\s*$/)){
            css_class = this.default_grid_class;
        }
        var bkg_color = this.default_grid_color;
        var cell_id = 0;
        var target = document.getElementById(this.actual_grid_dom);
        if (target === null){
            window.alert('ERROR: no DOM element with id="' + this.actual_grid_dom + '" was found!');
            return;
        }
        if (this.grid_cell_onclick === null){
            window.alert('ERROR: function to be called when a grid cell is clicked isn\'t specified!');
            return;
        }
        for (var i = 0; i < 16; i++){
            for (var j = 0; j < 16; j++){
                var div = document.createElement('div');
                div.setAttribute('id', 'palette-grid-cell-' + cell_id);
                div.setAttribute('title', cell_id);
                div.setAttribute('class', css_class);
                div.setAttribute('style', 'background:' + bkg_color + ';');
                div.setAttribute('color', bkg_color);
                div.setAttribute('onclick', this.grid_cell_onclick + '(' + cell_id + ');');
                target.appendChild(div);
                cell_id++;
            }
            var br = document.createElement('br');
            target.appendChild(br);
        }
    };
    
    this.getGridCellColor = function(cell_id){
        if (cell_id < 0){ cell_id = 0; }
        if (cell_id > 255){ cell_id = 255; }
        var color = document.getElementById('palette-grid-cell-' + cell_id).getAttribute('color');
        //var color_components = color.substring(5, color.length - 1).split(',');
        return color;
    };
    
    this.setGridCellColor = function(cell_id, color){
        if (cell_id < 0){ cell_id = 0; }
        if (cell_id > 255){ cell_id = 255; }
        var cell = document.getElementById('palette-grid-cell-' + cell_id);
        cell.setAttribute('color', color);
        cell.setAttribute('style', 'background:' + color + ';');
    };
    
    this.applyGradientFill = function(low, high){
        var dist = high - low;
        if (dist < 2){ return; }
        var color_string_low = document.getElementById('palette-grid-cell-' + low).getAttribute('color');
        var color_components_low = color_string_low.substring(5, color_string_low.length - 1).split(',');
        var color_string_high = document.getElementById('palette-grid-cell-' + high).getAttribute('color');
        var color_components_high = color_string_high.substring(5, color_string_high.length - 1).split(',');
        var r, g, b, a, rgba;
        for (var j = 1; j < dist; j++){
            keyColors[low + j] = 0;
            r = parseInt(color_components_low[0]) + parseInt((parseInt(color_components_high[0]) - parseInt(color_components_low[0])) * (j / dist));
            g = parseInt(color_components_low[1]) + parseInt((parseInt(color_components_high[1]) - parseInt(color_components_low[1])) * (j / dist));
            b = parseInt(color_components_low[2]) + parseInt((parseInt(color_components_high[2]) - parseInt(color_components_low[2])) * (j / dist));
            a = parseInt(color_components_low[3]) + parseInt((parseInt(color_components_high[3]) - parseInt(color_components_low[3])) * (j / dist));
            rgba = 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')';
            document.getElementById('palette-grid-cell-' + (low + j)).setAttribute('color', rgba);
            document.getElementById('palette-grid-cell-' + (low + j)).setAttribute('style', 'background:' + rgba + ';');
        }
        keyColors[low] = 1;
        keyColors[high] = 1;
    };
    
    this.applyFloodFill = function(low, high, c_source){        
        var color = document.getElementById('palette-grid-cell-' + c_source).getAttribute('color');
        for (var j = low; j <= high; j++){
            keyColors[j] = 0;
            document.getElementById('palette-grid-cell-' + j).setAttribute('color', color);
            document.getElementById('palette-grid-cell-' + j).setAttribute('style', 'background:' + color + ';');
        }
        keyColors[low] = 1;
        keyColors[high] = 1;
    };
    
    this.resetPaletteEditorGrid = function(){
        for (var i = 0; i < 256; i++){
            document.getElementById('palette-grid-cell-' + i).setAttribute('color', this.default_grid_color);
            document.getElementById('palette-grid-cell-' + i).setAttribute('style', 'background:' + this.default_grid_color + ';');
        }
    };
    
    // Imports a palette from an IDRISI palette file.
    this.importIDRISIPaletteFile = function(input){
        if (!(window.File && window.FileReader && window.FileList && window.Blob)){
            window.alert("This browser doesn't support File API!");
            return;
        }
        var fileInput = document.getElementById(input);
        var file = fileInput.files[0];
        if (file === undefined || file === null){
            window.alert('No file to import!');
            return;
        }
        if (!file.name.match(/.*\.(smp|SMP|Smp)/gi)){
            window.alert("The selected file isn't an SMP file!");
            return;
        }
        if (file.size !== 786){
            window.alert("The selected file isn't an IDRISI palette!");
            return;
        }        
        // Create the file reader
        var reader = new FileReader();
        reader.onload = (function(theFile){
            return function(e){
                var text = atob(e.target.result.substring(e.target.result.indexOf(',') + 1));
                if (text.substring(1, 7) !== 'IDRISI'){
                    window.alert("The selected file isn't an IDRISI palette!");
                    return;
                }
                var r, g, b, color;
                for (var i = 0; i < 256; i++){
                    r = text[i * 3 + 18].charCodeAt(0);
                    g = text[i * 3 + 19].charCodeAt(0);
                    b = text[i * 3 + 20].charCodeAt(0);
                    color = 'rgba(' + r + ',' + g + ',' + b + ',1)';
                    document.getElementById('palette-grid-cell-' + i).setAttribute('color', color);
                    document.getElementById('palette-grid-cell-' + i).setAttribute('style', 'background:' + color + ';');
                }
            };
        })(file);
        reader.readAsDataURL(file);
    };
    
    // WARNING: In its current realization, the export doesn't work in IE.
    this.exportToIDRISIPalette = function(){
        var IDRISI = [0x5b, 0x49, 0x44, 0x52, 0x49, 0x53, 0x49, 0x5d, 0x01,
                      0x0a, 0x08, 0x12, 0xff, 0x00, 0x00, 0x00, 0xff, 0x00];
        var color_string, color_components;
        var buffer = new ArrayBuffer(786);
        var byteView = new Uint8Array(buffer);
        for (var i = 0; i < 18; i++){ byteView[i] = IDRISI[i]; }
        for (var i = 0; i < 256; i++){
            color_string = document.getElementById('palette-grid-cell-' + i).getAttribute('color');
            color_components = color_string.substring(5, color_string.length - 1).split(',');
            byteView[i * 3 + 18] = color_components[0] & 0xff;
            byteView[i * 3 + 19] = color_components[1] & 0xff;
            byteView[i * 3 + 20] = color_components[2] & 0xff;
        }
        var filetext = "";
        for (var i = 0; i < 786; i++){ filetext += String.fromCharCode(byteView[i]); }
        var b64file = btoa(filetext);
        var data = 'data:application/octet-stream;base64,' + b64file;
        var dllink = document.createElement('a');
        dllink.setAttribute('id', 'palette-export-dllink');
        dllink.setAttribute('download', 'palette.smp');
        dllink.setAttribute('href', data);
        dllink.setAttribute('style', 'display:none;');
        var target = document.getElementById(this.actual_grid_dom);
        target.appendChild(dllink);
        // Prompt file download
        dllink.click();
        // Remove the now-unnecessary link
        document.getElementById('palette-export-dllink').remove();
    };
    
    this.convertToHex = function(red, green, blue){
        var color = '#';
        red = parseInt(red).toString(16);
        if (red.length === 1){ red = '0' + red;}
        green = parseInt(green).toString(16);
        if (green.length === 1){ green = '0' + green;}
        blue = parseInt(blue).toString(16);
        if (blue.length === 1){ blue = '0' + blue;}
        color += red + green + blue;
        return color;
    };
    
    this.convertToHex = function(rgb_array){
        var color = '#';
        var red = parseInt(rgb_array[0]).toString(16);
        if (red.length === 1){ red = '0' + red;}
        var green = parseInt(rgb_array[1]).toString(16);
        if (green.length === 1){ green = '0' + green;}
        var blue = parseInt(rgb_array[2]).toString(16);
        if (blue.length === 1){ blue = '0' + blue;}
        color += red + green + blue;
        return color;
    };
    
    this.convertToRGBstring = function(hex){
        var red = parseInt('0x' + hex.substring(1, 3));
        var green = parseInt('0x' + hex.substring(3, 5));
        var blue = parseInt('0x' + hex.substring(5, 7));
        var color = 'rgb(' + red + ',' + green + ',' + blue + ')';
        return color;
    };
    
    this.convertToRGBAstring = function(hex){
        var red = parseInt('0x' + hex.substring(1, 3));
        var green = parseInt('0x' + hex.substring(3, 5));
        var blue = parseInt('0x' + hex.substring(5, 7));
        var alpha = parseInt('0x' + hex.substring(7, 9));
        var color = 'rgb(' + red + ',' + green + ',' + blue + ',' + alpha + ')';
        return color;
    };
}
