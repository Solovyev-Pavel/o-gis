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
 *     This object controls the access to various functions of the editor     *
 * ************************************************************************** */

function CompositionEditorAuthenticate(){
    this.parent = null;         // parent class
    
    // Sets the parent of this object
    this.setParent = function(editor){ this.parent = editor; };
    
    // Begin authentication
    this.beginAuthentication = function(){
        document.cookie = 'PHPSESSID=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        $('#' + this.parent.params.authWindow).empty();
        var html =  '<table width="100%"><tr><td width="100px">Login:&nbsp</td><td><input id="usernamefield" type="text" ' +
                    'style="width:100%"/></td></tr><tr><td>Password:&nbsp;</td><td><input id="passwordfield" type="password" ' +
                    'style="width:100%;"/></td></tr></table>';
        $('#' + this.parent.params.authWindow).append(html);
        $('#' + this.parent.params.authWindow).dialog("open");
        return;
    };
    
    // Sending authentivation request
    this.sendAuthenticationRequest = function(){
        var username = $('#usernamefield').val();
        var password = $('#passwordfield').val();
        if (username === '' || username.match(/^\s+/g)){
            alert("You did not enter your login!");
            return;
        }
        if (password === ''){
            alert("You did not enter your password!");
            return;
        }
        $('#' + this.parent.params.authWindow).dialog("close");
        var c_editor = this;
        $.post("/o-gis/web/app.php/auth/editor?username=" + username + "&password=" + password, function(data){
            if (data.toString().match(/^Error/g)){
                var message = data.substring(7);
                var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td> '+
                            '<td valign="middle">' + message + '</td></tr></table>';
            }
            else {
                var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/ok.png"/></td> '+
                            '<td valign="middle">You\'ve been successfully logged in!</td></tr></table>';
                c_editor.parent.user = {};
                c_editor.parent.user.id = data.id;
                c_editor.parent.user.name = data.name;
                c_editor.parent.user.favRoot = "/o-gis/web/app.php/catalog/user/" + data.id;
                document.cookie = 'PHPSESSID=' + data.session + ';PATH=/;';
                $('#' + c_editor.parent.params.addLayerWindow).empty();
            }
            $( "#messagewindow" ).dialog('option', 'title', 'O-GIS Login');
            $( "#messagewindow" ).empty();
            $( "#messagewindow" ).append(html);
            $( "#messagewindow" ).dialog("open");
        });
    };
}
