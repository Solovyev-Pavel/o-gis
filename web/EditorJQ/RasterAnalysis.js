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
 *      This objects defines the client-side functions for raster analysis    *
 * ************************************************************************** */

// TODO: find a fix that would allow to use two different raster layers with the
// same public name in the algebra without mixing them up

function CompositionEditorRasterAnalysis(){
    this.parent = null;             // parent class
    this.RasterOperation = null;    // raster operation object
    this.treeReboot = false;        // flag to update the available layers trees
    
    // Sets the parent
    this.setParent = function(editor){ this.parent = editor; };
    
    // Show the starting screen
    this.beginRasterOperations = function(){
        if (this.parent.user === null){
            var html =  '<table><tr><td width="64px"><img src="./img/error.png"/></td><td valign="middle">' +
                        'You need to login in order to perform raster analysis!</td></tr></table>';
            $( "#messagewindow2" ).empty().append(html);
            $( "#messagewindow2" ).dialog("open");
            return;
        }
        if (this.parent.user.limit === 0){
            var html =  '<table><tr><td width="64px"><img src="./img/error.png"/></td><td valign="middle">' +
                        'You\'ve reached the allowed limit of layers on your profile and can\'t perform' +
                        'raster analysis operations!</td></tr></table>';
            $( "#messagewindow" ).dialog('option', 'title', 'Error');
            $( "#messagewindow" ).empty().append(html);
            $( "#messagewindow" ).dialog("open");
            return;
        }
        this.RasterOperation = {};
        var html = '<table width="100%"><tr>' +
                    '<td colspan="2">Select a raster operation you want to perform:</td></tr><tr><td colspan="2"><ul>' +
                    '<li><b>Raster Reclassification</b> - Creates a new raster layer, each point of which is assigned a value ' +
                    'based on which class the corresponding point from the original layer sorts with.</li>' +
                    '<li><b>Raster Algebra</b> - Creates a new raster layer, the value of each point of which is the result ' +
                    'of applying a math formula to the corresponding points of the source layes.</li></ul></td></tr>' +
                    '</ul></td></tr><tr><td><button type="button" style="width:200px;height:40px" onclick="' + this.parent.params.thisVar +
                    '.RasterAnalysis.beginReclassification();">Begin Raster Reclassification</button></td><td><button type="button" ' +
                    'style="width:200px;height:40px" onclick="' + this.parent.params.thisVar + '.RasterAnalysis.beginAlgebra();">' +
                    'Begin Raster Algebra</button></td></tr></table>';
        if (this.parent.user.limit > 0){
            html += '<br/><div><center style="font-size:13px;">You can created <b>' + this.parent.user.limit;
            if (this.parent.user.limit !== 11 && this.parent.user.limit % 10 === 1){ html += '</b> more layer.'; }
            else{ html += '</b> more layers.'; }
            html += '</center></div>';
        }
        $('#' + this.parent.params.rasterOpWindow).dialog('option', 'title', 'Select Raster Operation');
        $('#' + this.parent.params.rasterOpWindow).empty().append(html);
        $('#' + this.parent.params.rasterOpWindow).dialog("open");
    };
    
    // Raster reclassification
    this.beginReclassification = function(){
        this.RasterOperation.isReclassification = true;
        this.RasterOperation.rows = 2;
        this.RasterOperation.selectedRasters = [];
        var html = '<table width="100%"><tr><td id="selectedRasterName">Select a Layer...</td>' +
                    '<td width="100px"><button type="button" style="height:30px;" onclick="' + this.parent.params.thisVar +
                    '.RasterAnalysis.showSelectRasterWindow();">Select Layer</button></td></tr><tr><td colspan="2" ' +
                    'id="selectedRasterInfo">&nbsp;</td></tr></table><br/><div style="width:100%;height:200px;overflow-y:scroll">' +
                    '<table id="classestable" style="width:calc(100% - 10px)" cellspacing="0">' +
                        '<tr style="text-align:center"><th width="33%">Assign Value</th><th width="34%">From...</th><th>To...</th></tr>' +
                        '<tr id="rowclass-0"><td><input id="value-0-1" style="width:calc(100% - 6px)" /></td><td><input id="value-0-2" style="width:calc(100% - 6px)" /></td><td><input id="value-0-3" style="width:calc(100% - 4px)" /></td></tr>' +
                        '<tr id="rowclass-1"><td><input id="value-1-1" style="width:calc(100% - 6px)" /></td><td><input id="value-1-2" style="width:calc(100% - 6px)" /></td><td><input id="value-1-3" style="width:calc(100% - 4px)" /></td></tr>' +
                    '</table></div>' +
                    '<div style="width:100%;margin-top:8px;"><center>' +
                    '<button id="addrasterclass" style="height:30px;" type="button" onclick="' + this.parent.params.thisVar +
                    '.RasterAnalysis.addRasterClass()">Add Class</button>&nbsp;<button id="removerasterclass" ' +
                    'style="height:30px;" type="button" onclick="' + this.parent.params.thisVar + '.RasterAnalysis.removeRasterClass()">' +
                    'Remove Class</button>&nbsp;<button type="button" onclick="' + this.parent.params.thisVar +
                    '.RasterAnalysis.validateReclassification();" style="height:30px;">Continue</button></center></div>';
        $('#' + this.parent.params.rasterOpWindow).dialog('option', 'title', 'Raster Reclassification');
        $('#' + this.parent.params.rasterOpWindow).empty().append(html);
    };
    
    // Show the window with available raster layers
    this.showSelectRasterWindow = function(){
        if ($('#' + this.parent.params.selectRasterWindow).children().length === 0){
            var html = '<iframe style="width:99%;height:200px;" src="./app.php/list/rasters_editor" />';
            $('#' + this.parent.params.selectRasterWindow).append(html);
        }
        $('#' + this.parent.params.selectRasterWindow).dialog("open");
    };
    
    // Add a class to Reclassification
    this.addRasterClass = function(){
        var html = '<tr id="rowclass-' + this.RasterOperation.rows + '"><td><input id="value-' + this.RasterOperation.rows + '-1" ' +
                    'style="width:calc(100% - 6px)" /></td><td><input id="value-' + this.RasterOperation.rows + '-2" ' +
                    'style="width:calc(100% - 6px)" /></td><td><input id="value-' + this.RasterOperation.rows + '-3" ' +
                    'style="width:calc(100% - 4px)" /></td></tr>';
        $('#classestable').append(html);
        this.RasterOperation.rows++;
        if (this.RasterOperation.rows >= 16){ document.getElementById('addrasterclass').disabled = true; }
        if (this.RasterOperation.rows >= 1){ document.getElementById('removerasterclass').disabled = false; }
    };
    
    // Remove the last class from Reclassification
    this.removeRasterClass = function(){
        this.RasterOperation.rows--;
        $('#rowclass-' + this.RasterOperation.rows).remove();
        if (this.RasterOperation.rows < 16){ document.getElementById('addrasterclass').disabled = false; }
        if (this.RasterOperation.rows <= 1){ document.getElementById('removerasterclass').disabled = true; }
    };
    
    // Validate raster Reclassification
    this.validateReclassification = function(){
        if (this.RasterOperation.selectedRasters === null){
            alert('You need to select a raster layer!');
            return;
        }
        var params = [];
        for (var i = 0; i < this.RasterOperation.rows; i++){
            var _class = {};
            _class.newval = document.getElementById('value-' + i + '-1').value;
            _class.low = document.getElementById('value-' + i + '-2').value;
            _class.high = document.getElementById('value-' + i + '-3').value;
            if (isNaN(_class.newval) || /^\s*$/.test(_class.newval)){ continue; }
            if (isNaN(_class.low) || /^\s*$/.test(_class.low)){ continue; }
            if (isNaN(_class.high) || /^\s*$/.test(_class.high)){ continue; }
            if (parseFloat(_class.low) === parseFloat(_class.high)){ continue; }
            if (parseFloat(_class.low) > parseFloat(_class.high)){
                var tmp = _class.low;
                _class.low = _class.high;
                _class.high = tmp;
            }
            params.push(_class);
        }
        if (params.length === 0){
            alert('The values you\'ve entered are incomplete or erroneous!');
            return;
        }

        this.RasterOperation.operationParams = params;
        this.gatherRasterLayerOuputParams();
    };
    
    // Raster Algebra
    this.beginAlgebra = function(){
        this.RasterOperation.isReclassification = false;
        this.RasterOperation.selectedRasters = [];
        var func = this.parent.params.thisVar + '.RasterAnalysis.appendToAlgebraExpression(this.value);';
        var html =  '<center>Create a new layer according to this formula:</center><br/><textarea style="width:calc(100% - 8px);' +
                    'resize:none;" id="expressionArea" onkeydown="' + this.parent.params.thisVar +
                    '.RasterAnalysis.parseKeyboardInput(event);" onkeypress="javascript:return true" rows="8">' +
                    '</textarea><br/><div style="float:left;margin-right:20px;">' +
                    '<input class="smallRCbutton" type="button" value="7" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="8" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="9" onclick="' + func + '" /><br/>' +
                    '<input class="smallRCbutton" type="button" value="4" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="5" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="6" onclick="' + func + '" /><br/>' +
                    '<input class="smallRCbutton" type="button" value="1" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="2" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="3" onclick="' + func + '" /><br/>' +
                    '<input class="mediumRCbutton" type="button" value="0" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="." onclick="' + func + '" />' +
                    '</div><div style="float:left;">' +
                    '<input class="smallRCbutton" type="button" value="+" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="-" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="*" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="/" onclick="' + func + '" /><br/>' +
                    '<input class="smallRCbutton" type="button" value="(" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value=")" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="^" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="√" onclick="' + func + '" /><br/>' +
                    '<input class="smallRCbutton" type="button" value="sin" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="cos" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="tan" onclick="' + func + '" />&nbsp;' +
                    '<input class="smallRCbutton" type="button" value="ctg" onclick="' + func + '" /><br/>' +
                    '<input class="bigRCbutton" type="button" value="Add Raster Layer" onclick="' + this.parent.params.thisVar +
                    '.RasterAnalysis.showSelectRasterWindow();" /></div><div style="float:right;padding-right:2px;">' +
                    '<input style="width:120px;height:25px;" type="button" value="Continue" onclick="' + this.parent.params.thisVar +
                    '.RasterAnalysis.validateAlgebra();" />' +
                    '</div>';
        $('#' + this.parent.params.rasterOpWindow).dialog('option', 'title', 'Raster Algebra');
        $('#' + this.parent.params.rasterOpWindow).empty().append(html);
    };
    
    // Get cursor position
    this.getInputSelection = function(el){
        var start = 0, end = 0, normalizedValue, range, textInputRange, len, endRange;
        if (typeof el.selectionStart === "number" && typeof el.selectionEnd === "number") {
            start = el.selectionStart;
            end = el.selectionEnd;
        } else {
            range = document.selection.createRange();
            if (range && range.parentElement() === el) {
                len = el.value.length;
                normalizedValue = el.value.replace(/\r\n/g, "\n");
                // Create a working TextRange that lives only in the input
                textInputRange = el.createTextRange();
                textInputRange.moveToBookmark(range.getBookmark());
                // Check if the start and end of the selection are at the very end
                // of the input, since moveStart/moveEnd doesn't return what we want
                // in those cases
                endRange = el.createTextRange();
                endRange.collapse(false);
                if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                    start = end = len;
                } else {
                    start = -textInputRange.moveStart("character", -len);
                    start += normalizedValue.slice(0, start).split("\n").length - 1;
                    if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                        end = len;
                    } else {
                        end = -textInputRange.moveEnd("character", -len);
                        end += normalizedValue.slice(0, end).split("\n").length - 1;
                    }
                }
            }
        }
        return {
            start: start,
            end: end
        };
    };
    
    // Set cursor position
    this.setInputSelections = function(input, cursorPosition){
        if (input.setSelectionRange) {
            input.focus();
            input.setSelectionRange(cursorPosition, cursorPosition);
        }
        else if (input.createTextRange) {
            var range = input.createTextRange();
            range.collapse(true);
            range.moveEnd('character', cursorPosition);
            range.moveStart('character', cursorPosition);
            range.select();
        }
    };
    
    // Handle form's button click
    this.appendToAlgebraExpression = function(value){
        var text = document.getElementById('expressionArea').value;
        var cursorPos = this.getInputSelection(document.getElementById('expressionArea'));
        var prevChar = (text[cursorPos.start - 1] === undefined) ? null : text[cursorPos.start - 1];
        var nextChar = (text[cursorPos.end] === undefined) ? null : text[cursorPos.end];
        var step = 0;
        
        // if the cursor is inbetween { and } --> do nothing at all
        var pos = cursorPos.start;
        while (text[pos] !== undefined && text[pos] !== '}'){
            if (text[pos] === '{'){ return; }
            pos--;
        }

        if (value.match(/^\d$/)){                       // digits
            // can't follow: ), } <-- layer, 
            if (prevChar === ')' || prevChar === '}'){ return; }
            // can't precede: (, { <-- layer
            if (nextChar === '(' || nextChar === '{'){ return; }
            // if it is after + - * /, but before whitespace --> move cursor one symbol to the right
            if (prevChar !== null && prevChar.match(/[\+\-\*\/]/) && nextChar === ' '){ cursorPos.end++; }
            // if it is after whitespace, but before + - * / --> move cursor one symbol to the left
            if (nextChar !== null && prevChar === ' ' && nextChar.match(/[\+\-\*\/]/)){ cursorPos.start--; }
            text = text.substring(0, cursorPos.start) + value + text.substring(cursorPos.end);
            step = 1;
        }
        if (value.match(/^[\+\*\/]$/)){                 // stictly binary operation operators
            // can't lead the expression, can't follow or precede one another
            if (prevChar === null || prevChar === ' ' || nextChar === ' '){ return; }
            text = text.substring(0, cursorPos.start) + ' ' + value + ' ' + text.substring(cursorPos.end);
            step = 3;
        }
        if (value === '-'){                             // minus
            // can't precede any binary operator or unary minus; can't follow itself
            if (nextChar === '-' || nextChar === ' ' || prevChar === '-'){ return; }
            // if it's the first character or follows binary operator or precedes ( { --> unary minus
            if (cursorPos.end === 0 || prevChar === ' ' || nextChar === '(' || nextChar === '{'){
                text = text.substring(0, cursorPos.start) + value + text.substring(cursorPos.end);
                step = 1;
            }
            // if it follows a digit or ) } --> binary minus
            if (prevChar !== null && prevChar.match(/[\d\)\}]/)){
                text = text.substring(0, cursorPos.start) + ' ' + value + ' ' + text.substring(cursorPos.end);
                step = 3;
            }
        }
        if (value === '.'){                             // dot
            // can only follow a digit
            if (prevChar === null || !prevChar.match(/\d/)){ return; }
            // there can only be one per number
            // check back
            if (prevChar !== null){
                var pos = cursorPos.start - 1;
                while (pos >= 0 && !text[pos].match(/[\(\-\s]/)){
                    if (text[pos] === '.'){ return; }
                    pos--;
                }
            }
            // check forward
            if (nextChar !== null){
                pos = cursorPos.end;
                while(pos < text.length && !text[pos].match(/[\)\s]/)){
                    if (text[pos] === '.'){ return; }
                    pos++;
                }
            }
            text = text.substring(0, cursorPos.start) + value + text.substring(cursorPos.end);
            step = 1;
        }
        if (value === '('){
            // can't go right after binary operators, ) and }
            if (prevChar !== null && prevChar.match(/[\d\.\+\*\/\)\}]/)){ return; }
            text = text.substring(0, cursorPos.start) + value + text.substring(cursorPos.end);
            step = 1;
        }
        if (value === ')'){
            if (cursorPos.start === 0){ return; }
            // can't go right before binary operators, ( and {
            if (nextChar !== null && nextChar.match(/[\d\.\+\-\*\/\())\{]/)){ return; }
            text = text.substring(0, cursorPos.start) + value + text.substring(cursorPos.end);
            step = 1;
        }
        if (value === '^'){                             // power
            // can't lead the expression, can't precede or follow another binary opration
            if (prevChar === null || prevChar === ' ' || nextChar === ' '){ return; }
            text = text.substring(0, cursorPos.start) + ' ^ ' + text.substring(cursorPos.end);
            step = 3;
        }
        if (value === '√'){
            // can't follow a number without something in-between
            if (prevChar !== null && prevChar.match(/[\d\.]/)){ return; }
            text = text.substring(0, cursorPos.start) + 'sqrt()' + text.substring(cursorPos.end);
            step = 5;
        }
        if (value === 'sin' || value === 'cos' || value === 'tan' || value === 'ctg'){
            // can't follow a number without something in-between
            if (prevChar !== null && prevChar.match(/[\d\.]/)){ return; }
            text = text.substring(0, cursorPos.start) + value + '()' + text.substring(cursorPos.end);
            step = 4;
        }
        document.getElementById('expressionArea').value = text;
        this.setInputSelections(document.getElementById('expressionArea'), cursorPos.start + step);
    };
    
    // Parse keyboard input for algebra expression
    // TODO: fix backspace and delete
    this.parseKeyboardInput = function(event){
        var charCode = (event.which !== 0) ? event.which : event.keyCode;
        if ((charCode < 37 || (charCode > 40 && charCode < 112) || charCode > 128) && charCode !== 9){ event.preventDefault(); }
        var text = document.getElementById('expressionArea').value;
        var cursorPos = this.getInputSelection(document.getElementById('expressionArea'));
        var prevChar = (text[cursorPos.start - 1] === undefined) ? null : text[cursorPos.start - 1];
        var nextChar = (text[cursorPos.end] === undefined) ? null : text[cursorPos.end];
        var step = 0;

        // if the cursor is inbetween { and } --> only backspace and delete are allowed
        var pos = cursorPos.start;
        var layer = false;
        while (text[pos] !== undefined && text[pos] !== '}'){
            if (text[pos] === '{'){ layer = true; break; }
            pos--;
        }
        if (layer && charCode !== 8 && charCode !== 46){ return; }

        // if the shift key is down
        if (event.shiftKey){
            // brackets
            if (charCode === 48){
                // closing bracket can't go immediately after whitespace, + - * /; it can't also be the very first symbol
                if (prevChar === null || prevChar.match(/[\s\+\-\*\/]/)){ return; }
                // it also can't go immediately before variable or a constant or an opening bracket or an operation sign
                if (nextChar !== null && nextChar.match(/[\d\{\(\+\-\*\/]/)){ return; }
                text = text.substring(0, cursorPos.start) + ')' + text.substring(cursorPos.end);
                step = 1;
            }
            if (charCode === 57){
                // opening bracket can't go immediately after a closing one or a variable or a constant or + * /
                if (prevChar !== null && prevChar.match(/[\)\}\d\+\*\/]/)){ return; }
                // it also can't go immediately before an operation sign
                if (nextChar !== null && nextChar.match(/[\+\-\*\/]/)){ return; }
                text = text.substring(0, cursorPos.start) + '(' + text.substring(cursorPos.end);
                step = 1;
            }
            // mutliply and plus
            if (charCode === 56 || charCode === 61 || charCode === 187){
                // can't lead the expression, can't follow or precede one another
                var char = (charCode === 56) ? '*' : '+';   
                if (prevChar === null || prevChar.match(/[\s\+\-\*\/]/)){ return; }
                if (nextChar !== null && nextChar.match(/[\s\+\*\/]/)){ return; }
                text = text.substring(0, cursorPos.start) + ' ' + char + ' ' + text.substring(cursorPos.end);
                step = 3;
            }
        }
        else{
            // digits
            if ((charCode > 47 && charCode < 58) || (charCode > 95 && charCode < 106) || charCode === 110){
                // can't follow + * / without whitespace as a separator, can't follow ) }
                if (prevChar !== null && prevChar.match(/[\+\*\/\)\}]/)){ return; }
                // can't precede + - * / without whitespace as a separator and ( {
                if (nextChar !== null && nextChar.match(/[\+\-\*\/\(\{]/)){ return; }
                text = text.substring(0, cursorPos.start) + String.fromCharCode(charCode) + text.substring(cursorPos.end);
                step = 1;
            }
            // dot
            if (charCode === 190){
                // can only follow digits or (
                if (prevChar !== null && !prevChar.match(/[\s\d\(]/)){ return; }
                // can only be followed by digits or )
                if (nextChar !== null && !nextChar.match(/[\s\d\)]/)){ return; }
                // there can only be one per number
                // check back
                if (prevChar !== null){
                    var pos = cursorPos.start - 1;
                    while (pos >= 0 && !text[pos].match(/[\(\-\s]/)){
                        if (text[pos] === '.'){ return; }
                        pos--;
                    }
                }
                // check forward
                if (nextChar !== null){
                    pos = cursorPos.end;
                    while(pos < text.length && !text[pos].match(/[\)\s]/)){
                        if (text[pos] === '.'){ return; }
                        pos++;
                    }
                }
                text = text.substring(0, cursorPos.start) + '.' + text.substring(cursorPos.end);
                step = 1;
            }
            // + * /
            if (charCode === 106 || charCode === 107 || charCode === 111 || charCode === 191){
                // can't lead the expression, can't follow or precede one another
                if (prevChar === null || prevChar.match(/[\s\+\-\*\/]/)){ return; }
                if (nextChar !== null && nextChar.match(/[\s\+\*\/]/)){ return; }
                text = text.substring(0, cursorPos.start) + ' ' + String.fromCharCode(charCode) + ' ' + text.substring(cursorPos.end);
                step = 3;
            }
            // minus
            if (charCode === 109 || charCode === 173){
                // can't precede any binary operator or unary minus; can't follow itself
                if (nextChar === '-' || nextChar === ' ' || prevChar === '-'){ return; }
                // if it's the first character or follows binary operator or precedes ( { --> unary minus
                if ((cursorPos.end === 0) || (prevChar === ' ') || (prevChar === '(') || (nextChar !== null && nextChar.match(/[\d\(\{]/))){
                    text = text.substring(0, cursorPos.start) + '-' + text.substring(cursorPos.end);
                    step = 1;
                }
                // if it follows a digit or ) } --> binary minus
                if (prevChar !== null && prevChar.match(/[\d\.\)\}]/)){
                    text = text.substring(0, cursorPos.start) + ' - ' + text.substring(cursorPos.end);
                    step = 3;
                }
            }
            // backspace
            if (charCode === 8){
                // if we're at the beginning of the string, there is nothing to delete with backspace
                if (cursorPos.end === 0){ return; }
                // if the previous symbol is } - delete everything up to and including the first { before it
                if (prevChar === '}'){
                    pos = cursorPos.start;
                    while (text[pos] !== '{'){ pos--; step--; }
                    text = text.substring(0, pos) + text.substring(cursorPos.end);
                }
                else if (layer){
                        var end = text.indexOf('}', cursorPos.start);
                        text = text.substring(0, pos) + text.substring(end + 1);
                        step = cursorPos.start - pos;
                    }
                else if ( prevChar === '(' ){
                    // if the character before is 'n' (sin, tan), 's' (cos) or 'g' (ctg) - delete 4 symbols
                    if (text[cursorPos.start - 2] !== undefined && text[cursorPos.start - 2].match(/[gns]/)){
                        text = text.substring(0, cursorPos.start - 4) + text.substring(cursorPos.end);
                        step = -4;
                    }
                    // if the character before is 't' (sqrt) - delete 5 symbols
                    else if (text[cursorPos.start - 2] === 't'){
                        text = text.substring(0, cursorPos.start - 5) + text.substring(cursorPos.end);
                        step = -5;
                    }
                    else{
                        text = text.substring(0, cursorPos.start - 1) + text.substring(cursorPos.end);
                        step = -1;
                    }
                }
                else{
                    // if the previous character is a digit, dot or unary minus - delete it
                    if ((prevChar !== null && prevChar.match(/[\d\.\)]/)) || (prevChar === '-' && nextChar !== ' ')){
                        text = text.substring(0, cursorPos.start - 1) + text.substring(cursorPos.end);
                        step = -1;
                    }
                    // if the previous character is binary operator - delete it and whitespaces surrounding it
                    if (prevChar !== null && prevChar.match(/[\+\-\*\/\^]/) && nextChar === ' '){
                        text = text.substring(0, cursorPos.start - 2) + text.substring(cursorPos.end + 1);
                        step = -2;
                    }
                    // if the previous character is whitespace and the one before it is binary operator, delete 3 characters
                    if (prevChar === ' ' && text[cursorPos.start - 2] !== undefined && text[cursorPos.start - 2].match(/[\+\-\*\/\^]/)){
                        text = text.substring(0, cursorPos.start - 3) + text.substring(cursorPos.end);
                        step = -3;
                    }
                    else if (nextChar === null && prevChar === ' ' && text[cursorPos.start - 2] !== undefined && text[cursorPos.start - 2].match(/[\d\.]/)){
                        text = text.substring(0, cursorPos.start - 1) + text.substring(cursorPos.end);
                        step = -1;
                    }
                }
            }
            // delete
            if (charCode === 46){
                // if the cursor is after the last symbol in string - we have nothing to delete
                if (nextChar === null){ return; }
                // if the next char is { - delete everything up to and including the closes }
                if (nextChar === '{'){
                    pos = cursorPos.end;
                    while (text[pos] !== '{'){ pos++; }
                    text = text.substring(0, cursorPos.start) + text.substring(pos + 1);
                }
                else if (layer){
                    var end = text.indexOf('}', cursorPos.start);
                    text = text.substring(0, pos - 1) + text.substring(end + 1);
                    step = cursorPos.start - pos;
                }
                else if (nextChar === '('){
                     // if the character before is 'n' (sin, tan), 's' (cos) or 'g' (ctg) - delete 4 symbols
                    if (text[cursorPos.start - 2] !== undefined && text[cursorPos.start - 2].match(/[gns]/)){
                        text = text.substring(0, cursorPos.start - 3) + text.substring(cursorPos.end + 1);
                        step = -3;
                    }
                    // if the character before is 't' (sqrt) - delete 5 symbols
                    else if (text[cursorPos.start - 2] === 't'){
                        text = text.substring(0, cursorPos.start - 4) + text.substring(cursorPos.end + 1);
                        step = -4;
                    }
                    else{
                        text = text.substring(0, cursorPos.start - 1) + text.substring(cursorPos.end);
                        step = -1;
                    }
                }
                else{
                    // if the next char is digit, dot, bracket or unary minus - delete
                    if (nextChar !== null && nextChar.match(/[\d\.\(\)]/)){
                        text = text.substring(0, cursorPos.start) + text.substring(cursorPos.end + 1);
                    }
                    if (nextChar === '-' && text[cursorPos.end + 1] !== ' '){
                        text = text.substring(0, cursorPos.start) + text.substring(cursorPos.end + 1);
                    }
                    // if the next char is a binary operator, delete 2 symbols forward, one symbol back
                    if (nextChar !== null && nextChar.match(/[\+\-\*\/]/) && text[cursorPos.end + 2] === ' '){
                        text = text.substring(0, cursorPos.start - 1) + text.substring(cursorPos.end + 2);
                        step = -1;
                    }
                    // if the next char is whitespace and previous is a binary operator - delete 2 symbols back one symbol forward
                    if (nextChar === ' ' && prevChar !== null && prevChar.match(/[\+\-\*\/]/)){
                        text = text.substring(0, cursorPos.start - 2) + text.substring(cursorPos.end + 1);
                        step = -2;
                    }
                }
            }
        }

        document.getElementById('expressionArea').value = text;
        this.setInputSelections(document.getElementById('expressionArea'), cursorPos.start + step);
    };
    
    // Process selected raster layer
    this.useRasterLayer = function(params, text){
       $('#' + this.parent.params.selectRasterWindow).dialog('close');
        if (this.RasterOperation.isReclassification){
            var cs = params[0].substring(params[0].indexOf(':') + 1);
            var ws = params[0].substring(0, params[0].indexOf(':'));
            var ndt = (params[3] % 1 === 0) ? params[3] : parseFloat(params[3]).toFixed(5);
            var max = (params[2] % 1 === 0) ? params[2] : parseFloat(params[2]).toFixed(5);
            var min = (params[1] % 1 === 0) ? params[1] : parseFloat(params[1]).toFixed(5);
            this.RasterOperation.selectedRasters = {"cs" : cs, "ws": ws};
            $('#selectedRasterName').empty().append('Selected Layer: <b>' + text + '</b>');
            $('#selectedRasterInfo').empty().append('<center>min: ' + min + '; max: ' + max + '; NODATA: ' + ndt + '</center>');
        }
        else{
            var inputtext = document.getElementById('expressionArea').value;
            var cursorPos = this.getInputSelection(document.getElementById('expressionArea'));
            var prevChar = (inputtext[cursorPos.start - 1] === undefined) ? null : inputtext[cursorPos.start - 1];
            var nextChar = (inputtext[cursorPos.end] === undefined) ? null : inputtext[cursorPos.end];

            // if the cursor is inbetween { and } --> do nothing at all
            // check back
            if (prevChar !== null){
                var pos = cursorPos.start - 1;
                while (pos >= 0 && inputtext[pos] !== '}'){
                    if (inputtext[pos] === '{'){ return; }
                    pos--;
                }
            }
            // check forward
            if (nextChar !== null){
                pos = cursorPos.end;
                while(pos < inputtext.length && inputtext[pos] !== '{'){
                    if (inputtext[pos] === '}'){ return; }
                    pos++;
                }
            }
            // check if we're trying to insert immediately before or immediately after some other value
            if (prevChar !== null && prevChar.match(/[\}\+\*\/\)\d\.]/)){ return; }
            if (nextChar !== null && nextChar.match(/[\(\{\+\-\*\/\d\.]/)){ return; }

            if (this.RasterOperation.selectedRasters === null){ this.RasterOperation.selectedRasters = []; }
            var cs = params[0].substring(params[0].indexOf(':') + 1);
            var ws = params[0].substring(0, params[0].indexOf(':'));
            var length = this.RasterOperation.selectedRasters.length;
            var is_used = false;
            for (var i = 0; i < length; i++){ if (this.RasterOperation.selectedRasters[i].cs === cs){ is_used = true; break; } }
            if (!is_used){ this.RasterOperation.selectedRasters.push({"cs": cs, "ws": ws, "text": text}); }
            inputtext = inputtext.substring(0, cursorPos.start) + '{' + text + '}' + inputtext.substring(cursorPos.end);
            document.getElementById('expressionArea').value = inputtext;
            this.setInputSelections(document.getElementById('expressionArea'), cursorPos.start + text.length + 2);
        }
    };
    
    //Validate raster Algeblra
    this.validateAlgebra = function(){
        var text = document.getElementById('expressionArea').value;
        var operation = {
            isReclassification: false,
            selectedRasters: [],
            operationParams: ''
        };
        var layerName = '', trueOperationString = '';
        var openingBrackets = 0, closingBrackets = 0;
        for (var i = 0; i < text.length; i++){
            if (text[i] === '('){ 
                trueOperationString += text[i];
                openingBrackets++; }
            else if (text[i] === ')'){
                trueOperationString += text[i];
                closingBrackets++; }
            else if (text[i] === '{'){
                layerName = '';
                while (text[i - 1] !== '}'){
                    layerName += text[i];
                    i++;
                }
                var layer = null;
                for (var j = 0; j < this.RasterOperation.selectedRasters.length; j++){
                    if ('{' + this.RasterOperation.selectedRasters[j].text + '}' === layerName){
                        layer = this.RasterOperation.selectedRasters[j];
                        layer.variable = 'layer' + (operation.selectedRasters.length + 1);
                    }
                }
                var is_used = false;
                for (var j = 0; j < operation.selectedRasters.length; j++){
                    if (operation.selectedRasters[j].cs === layer.cs){ is_used = true; break; }
                }
                if (!is_used){ operation.selectedRasters.push(layer); }
                trueOperationString += '{{' + layer.variable + '}}';
                i--;
            }
            else{
                trueOperationString += text[i];
            }
        }
        if (operation.selectedRasters.length === 0){
            alert('Error:\r\nYour expression must use at least one raster layer!');
            return;
        }
        if (trueOperationString.indexOf('()') !== -1){
            alert('Error:\r\nExpression containst a set of empty brackets!');
            return;
        }
        if (openingBrackets !== closingBrackets){
            alert('Error:\r\nMismatched brackets found!');
            return;
        }
        operation.operationParams = trueOperationString;
        operation.rowcounter = operation.selectedRasters.length;
        this.RasterOperation = operation;
        this.gatherRasterLayerOuputParams();
    };
    
    // Get the name, description and target catalog for the new layer
    this.gatherRasterLayerOuputParams = function(){
        var html =  '<table width="100%"><tr><td width="130px"><b>Layer Title</b>:</td><td>' +
                    '<input id="newrasterlayername" type="text" maxlength="256" style="width:100%" /></td></tr>' +
                    '<tr><td><b>Layer Description</b>:</td><td><textarea id="newrasterlayerdesc" ' +
                    'style="width:100%;height:75px;resize:none;" maxlength="1024"></textarea></td></tr>' + 
                    '<tr><td><b>Target Catalog</b>:</td><td><input type="hidden" id="newrasterlayercat" />' +
                    '<div id="saverastertree" style="max-width:285px;width:100%;height:150px;border:1px solid #ccc;overflow:auto;"></div></td></tr></table><br/>' +
                    '<center><button type="button" style="height:30px;width:80%;" onclick="' + this.parent.params.thisVar +
                    '.RasterAnalysis.createNewRasterLayer()">Perform Operation</button></center>';
        $('#' + this.parent.params.rasterOpWindow).dialog('option', 'title', 'Saving new Layer');
        $('#' + this.parent.params.rasterOpWindow).empty().append(html);
        showSaveRasterOperationTree(this.parent.user.favRoot);
    };
    
    // Validate the input for layer metadata and send request to the server
    this.createNewRasterLayer = function(){
        var name = document.getElementById('newrasterlayername').value;
        if(/^\s*$/gi.test(name)){
            alert('The name of the layer must contain meaningful symbols!');
            return;
        }
        var desc = document.getElementById('newrasterlayerdesc').value;
        var catid = document.getElementById('newrasterlayercat').value;
        if (catid === null || catid === ''){
            alert('You need to select the catalog into which the link to this layer will be placed!');
            return;
        }
        $('#' + this.parent.params.rasterOpWindow).dialog('close');
        var json_object = {
            name: name,
            desc: desc,
            target: catid,
            isReclass: this.RasterOperation.isReclassification,
            sources: this.RasterOperation.selectedRasters,
            params: this.RasterOperation.operationParams
        };
        var json = JSON.stringify(json_object);
        var c_editor = this.parent;
        this.parent.user.limit--;
        if (document.getElementById(this.parent.params.waitAnimBox)){
            $('#' + this.parent.params.waitAnimBox).css('display', 'block');
        }

        $.ajax({url: "./app.php/rasterop", method: "POST", data: json})
                .done(function(msg){
                    if (msg.success){
                        this.treeReboot = true;
                        $( "#messagewindow" ).dialog('option', 'title', 'Raster Operations');
                        var html =  '<table><tr><td width="64px"><img src="./img/ok.png"/></td><td valign="middle">' +
                                    msg.message + '</td></tr></table>';
                        $( "#messagewindow" ).empty().append(html);
                        $( "#messagewindow" ).dialog("open");
                        $( "#addlayerwindow" ).empty();
                    }
                    else{
                        $( "#messagewindow" ).dialog('option', 'title', 'Raster Operations');
                        var html =  '<table><tr><td width="64px"><img src="./img/error.png"/></td><td valign="middle">' +
                                    msg.message + '</td></tr></table>';
                        $( "#messagewindow" ).empty().append(html);
                        $( "#messagewindow" ).dialog("open");
                    }
                   //console.log(response);
                }).fail(function(){
                    c_editor.user.limit++;
                    $( "#messagewindow" ).dialog('option', 'title', 'Raster Operation');
                    var html =  '<table><tr><td width="64px"><img src="./img/error.png"/></td><td valign="middle">' +
                                'An error occured while processing your request!</td></tr></table>';
                    $( "#messagewindow" ).empty().append(html);
                    $( "#messagewindow" ).dialog("open");
                }).always(function(){
                    if (document.getElementById(c_editor.params.waitAnimBox)){
                        $('#' + c_editor.params.waitAnimBox).css('display', 'none');
                    }
                });
    };
}
