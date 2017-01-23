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
 *    Selects a node to which an object is added and sends request to DB      *
 *                                                                            *
 * Dependencies:                                                              *
 * - jQuery                                                                   *
 * - jstree by Ivan Bozhanov                                                  *
 * ************************************************************************** */

// Load children catalogs of the current catalog
function loadCatalogChildren(node){
    if (node.loaded !== undefined){ return; }
    var url = catalogData.replace('PATH', node.id);
    node.loaded = true;
    $.ajax(url)
        .done(function(msg){
            var tree = $('#targettree').jstree(true);
            if(!tree){ tree = $('#savetargettree').jstree(true); }
            for (var i = 0; i < msg.catalogs.length; i++){
                var newNode = msg.catalogs[i];
                tree.create_node(newNode.parent, newNode);
            }
            tree.open_node(node.id);
        })
        .fail(function(){
            console.log("Error while retrieving data!");
            delete node.loaded;
        });
}

// Adds catalog or link to favorites - part 1
function showTargetCatalogTree(id, type){
    if(id !== null){
        $('#targetnodeid').text(id);
    }
    if (type !== null){
        $('#targetnodetype').text(type);
        $('#selectednode').empty();
        $('#selectednodeid').empty();
    }
    if ($('#targettree').is(':empty')){
        $.ajax(rootFavNodes).done(function(msg){
            $('#targettree').jstree({
                'core': {
                    'multiple': false,
                    'data': msg.catalogs,
                    'check_callback': true
                },
                'types': {
                    "catalog": {icon: "./img/icons/catalog.png"}
                },
		'plugins': [ "sort", "types" ],
		'sort': function (a, b) {   return this.get_text(a) > this.get_text(b) ? 1 : -1; }
            }).on('select_node.jstree', function(e, data){
                loadCatalogChildren(data.node);
                $('#selectednode').text('Selected catalog: "' + data.node.text + '"');
                $('#selectednodeid').text(data.node.id); 
            });
        }).fail(function(){ console.log('error'); });
    }
    else{
        var tree = $('#targettree').jstree(true);
        tree.deselect_all();
    }
    $('#targetcatalogselector').dialog("open");
}

function showSaveTargetCatalogTree(){
    if ($('#savetargettree').is(':empty')){
        $.ajax(rootFavNodes).done(function(msg){
            $('#savetargettree').jstree({
                'core': {
                    'multiple': false,
                    'data': msg.catalogs,
                    'check_callback': true
                },
                'types': {
                    "catalog": {icon: "./img/icons/catalog.png"}
                },
		'plugins': [ "sort", "types" ],
		'sort': function (a, b) {   return this.get_text(a) > this.get_text(b) ? 1 : -1; }
            }).on('select_node.jstree', function(e, data){
                loadCatalogChildren(data.node);
                $('#targetcatid').text(data.node.id); 
            });
        });
    }
}

// Adds catalog or link to favorites - part 2
function sendAddToFavoritesRequest(){
    var type = $('#targetnodetype').text();
    if(type === 'raster' || type === 'line' || type === 'point' || type === 'polygon'){ type = 'layer'; }
    var id = $('#targetnodeid').text();
    var target = $('#selectednodeid').text();
    var url = addToFavRoute + '?type=' + type + '&id=' + id + '&parent=' + target;
    $.ajax({
        url: url,
        method: 'POST'
    }).done(function(msg){
        if(msg.success){
            var html = '<table><tr><td width="64px"><img src="./img/ok.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
            $( "#messagewindow" ).dialog('option', 'title', 'Adding to Favorites');
            $( "#messagewindow" ).empty().append(html);
            $( "#messagewindow" ).dialog("open");
        }
        else{
            var html = '<table><tr><td width="64px"><img src="./img/error.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
            $( "#messagewindow" ).dialog('option', 'title', 'Adding to favorites');
            $( "#messagewinow" ).empty().append(html);
            $( "#messagewinow" ).dialog("open");
        }
    }).fail(function(){
        var html = '<table><tr><td width="64px"><img src="./img/error.png"/></td><td valign="middle">Ошибка при добавлении в избранное!</td></tr></table>';
	      $( "#messagewindow" ).dialog('option', 'title', 'Adding to favorites');
        $( "#messagewinow" ).empty().append(html);
	      $( "#messagewinow" ).dialog("open");
    }).always(function(){
        buffer = null;
    });
}

// ------------------------------------------------------------------------------- //
//     Raster operations: needs separate instance of object for noninterference    //
// ------------------------------------------------------------------------------- //

function showSaveRasterOperationTree(target){
    if ($('#saverastertree').is(':empty')){
    	var url = (target === undefined || target === null) ? rootFavNodes : target;
        $.ajax(url).done(function(msg){
            $('#saverastertree').jstree({
                'core': {
                    'multiple': false,
                    'data': msg.catalogs,
                    'check_callback': true
                },
                'types': {
                    "catalog": {icon: "./img/icons/catalog.png"},
                    "catalog_r": {icon: "./img/icons/catalog.png"},
                    "catalog_n": {icon: "./img/icons/catalog.png"},
                    "catalog_d": {icon: "./img/icons/catalog.png"}
                },
		'plugins': [ "sort", "types" ],
		'sort': function (a, b) {   return this.get_text(a) > this.get_text(b) ? 1 : -1; }
            }).on('select_node.jstree', function(e, data){
                loadRasterCatalogChildren(data.node);
                document.getElementById('newrasterlayercat').value = data.node.id;
            });
        }).fail(function(msg){
                console.log('Error while building tree');
                console.log(msg);
        });
    }
}

function loadRasterCatalogChildren(node){
    if (node.loaded !== undefined){ return; }
    var url = catalogData.replace('PATH', node.id);
    node.loaded = true;
    $.ajax(url)
        .done(function(msg){
            var tree = $('#saverastertree').jstree(true);
            for (var i = 0; i < msg.catalogs.length; i++){
                var newNode = msg.catalogs[i];
                if(newNode.type === "catalog_n" || newNode.type === "catalog_d"){ continue; }
                tree.create_node(newNode.parent, newNode);
            }
            tree.open_node(node.id);
        })
        .fail(function(){
            console.log("Error while retrieving data!");
            delete node.loaded;
        });
}
