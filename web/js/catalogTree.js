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
 *               Displays a tree with user's links and catalogs               *
 *                                                                            *
 * Dependencies:                                                              *
 * - jQuery                                                                   *
 * - jstree by Ivan Bozhanov                                                  *
 * ************************************************************************** */
 
// Supplementary variable that holds the last added node's id
var lastCreatedNode = null;
var oldName = null;
var buffer = null;
var copyBuffer = null;
var isCopy = null;

// Loads contents of a catalog or opens a link
function loadCatalogContents(node){
    if (node.loaded !== undefined){ return; }
    if (!node.type.match(/^catalog/g)){
        if (node.type.match(/^external/g)){
            window.open(node.data, '_blank');
        }
        else{
            var type = node.type;
            if (type.match(/_/g)){
                type = type.substring(0, type.indexOf('_'));
            }
            console.log(node);
            if (type === 'raster' || type === 'line' || type === 'point' || type === 'polygon'){ type = 'layer'; }
            url = homepage + type + "/" + node.data;
            window.open(url, '_blank');
        }
        return;
    }
    
    node.loaded = true;
    var url = catalogData.replace('PATH', node.id);
    $.ajax(url)
        .done(function(msg){
            var tree = $('#foldertree').jstree(true);
            for (var i = 0; i < msg.catalogs.length; i++){
                var newNode = msg.catalogs[i];
                tree.create_node(newNode.parent, newNode);
            }
            for (var i = 0; i < msg.links.length; i++){
                var newNode = msg.links[i];
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
function addToFavorites(node){
    var type = node.type;
    if (type === 'raster' || type === 'point' || type === 'line' || type === 'polygon'){ type = 'layer'; }
    if (type.match(/_/g)){
        type = type.substring(0, type.indexOf('_'));
    }
    if (type === 'external'){ type = 'link'; }
    var id = node.id;
    if (type !== 'link' && type !== 'catalog'){ id = node.data; }
    showTargetCatalogTree(id, type);
}

// Supplementary function that creates a 'random' identifier
function generateGUID(){
    function s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }
    var guid = s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
    return guid;
}

// Creates a new catalog
function createCatalog(parent){
    var tree = $('#foldertree').jstree(true);
    var newNode = {
        type: 'catalog',
        text: 'Новый каталог',
        id: generateGUID(),
        flags: 'nrmpsd'
    };
    lastCreatedNode = newNode.id;   // so that we can distinguish created nodes from modified ones
    tree.create_node(parent.id, newNode);
    tree.open_node(parent.id);
    parent.loaded = true;
    tree.edit(newNode.id);
}

// Edit a catalog properties
function editCatalogProperties(node){
    var url = editCatalogRoute.replace('ID', node.id);
    window.open(url, '_blank');
}

// Renames a catalog
function renameCatalog(node){
    var tree = $('#foldertree').jstree(true);
    oldName = node.text;
    tree.edit(node.id);
}

// copy or cut a node to buffer
function copyNode(node, copying){
    isCopy = copying;
    var truetype = node.type;
    if (truetype === 'raster' || truetype === 'point' || truetype === 'line' || truetype === 'polygon'){ truetype = 'layer'; }
    if (truetype === 'external'){ truetype = 'link'; }
    copyBuffer = {text: node.text, type: node.type, data: node.data, id: node.id, parent: node.parent, truetype: truetype, flags: node.original.flags};
}

// paste node from buffer
function pasteNode(parent){
    var tree = $('#foldertree').jstree(true);
    if (isCopy){
        var data = (copyBuffer.truetype === 'link' || copyBuffer.truetype === 'catalog') ? copyBuffer.id : copyBuffer.data;
        var url = addToFavRoute + '?type=' + copyBuffer.truetype + '&id=' + data + '&parent=' + parent.id;
        $.ajax({
            url: url,
            method: 'POST'
        }).done(function(msg){
            if(msg.success){
                var id = msg.id;
                if (id === undefined){ id = copyBuffer.id; }
                var newNode = {
                    id: id,
                    text: copyBuffer.text,
                    type: copyBuffer.type,
                    data: copyBuffer.data,
                    flags: copyBuffer.flags
                };
                tree.create_node(parent.id, newNode);
                tree.open_node(parent.id);
                isCopy = null;
                copyBuffer = null;
            }
            else{
                var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
                $( "#errormessagewinow" ).empty().append(html);
                $( "#errormessagewinow" ).dialog("open");
                isCopy = null;
                copyBuffer = null;
            }
        }).fail(function(){
            var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">Error while performing this action!</td></tr></table>';
            $( "#errormessagewinow" ).empty().append(html);
            $( "#errormessagewinow" ).dialog("open");
            isCopy = null;
            copyBuffer = null;
        });
    }
    else{
        var url = cutPasteRoute + '?type=' + copyBuffer.truetype + '&id=' + copyBuffer.id + '&_to=' + parent.id + '&_from=' + copyBuffer.parent;
        $.ajax({
            url: url,
            method: 'POST'
        }).done(function(msg){
            if(msg.success){
                var target = tree.get_node(copyBuffer.id);
                tree.move_node(target, parent);
                tree.open_node(parent.id);  
                isCopy = null;
                copyBuffer = null;
            }
            else{
                var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
                $( "#errormessagewinow" ).empty().append(html);
                $( "#errormessagewinow" ).dialog("open");
                isCopy = null;
                copyBuffer = null;
            }
        }).fail(function(){
            var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">Error while performing this action!</td></tr></table>';
            $( "#errormessagewinow" ).empty().append(html);
            $( "#errormessagewinow" ).dialog("open");
            isCopy = null;
            copyBuffer = null;
        });
    }
}

// Saves a catalog to DB
function saveCatalog(node){
    var tree = $('#foldertree').jstree(true);
    var parent = tree.get_parent(node.id);
    var url = saveCatalogRoute + "?id=" + node.id + "&title=" + node.text + "&parent=";
    if (node.id === lastCreatedNode){
        url += parent;
        lastCreatedNode = null;
    }
    console.log(url);
    $.ajax({
        url: url,
        method: 'POST'
        }).done(function(msg){
            if (msg.success){ tree.set_id(node.id, msg.id); }
            else{
                tree.set_text(node.id, oldName);
                oldName = null;
                console.log(msg.message);
                var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
                $('#errormessagewinow').empty().append(html);
                $('#errormessagewinow').dialog('open');
            }
        }).fail(function(){
            tree.set_text(node.id, oldName);
            oldName = null;
            console.log(msg.message);
            var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">Error while perforimng this action!</td></tr></table>';
            $('#errormessagewinow').empty().append(html);
            $('#errormessagewinow').dialog('open');
        });
}

// Rename a link in DB
function saveUpdatedLink(node){
    var url = modifyLinkRoute + "?id=" + node.id + "&title=" + node.text;
    $.ajax({
        url: url,
        method: 'POST'
    }).done(function(msg){
        if(msg.success){ return; }
        var tree = $('#foldertree').jstree(true);
        tree.set_text(node.id, oldName);
        oldName = null;
        console.log(msg.message);
        var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
        $('#errormessagewinow').empty().append(html);
        $('#errormessagewinow').dialog('open');
    });
}

// Deletes a node from tree (if user has permissions to do that)
function deleteNode(node){
    var text = (node.type === 'catalog') ? 'catalog "' + node.text + '" and everything inside it?' : 'link "' + node.text + '"?' ;
    if (!confirm('Are you sure you want to delete  ' + text)){ return; }
    var tree = $('#foldertree').jstree(true);
    if (node.type !== 'catalog'){
        // just delete it
        var url = deleteLinkRoute.replace('ID', node.id);
        $.ajax({
                url: url,
                method: 'POST'
        }).done(function(msg){
            if(msg.success){ tree.delete_node(node.id); }
            else{
                var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
                $('#errormessagewinow').empty().append(html);
                $('#errormessagewinow').dialog('open');
            }
        }).fail(function(){
            var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">Error while deleting the link!</td></tr></table>';
            $('#errormessagewinow').empty().append(html);
            $('#errormessagewinow').dialog('open');
        });
    }
    else{
        var parent = tree.get_parent(node.id);
        if (node.original.flags.match(/u/i)){
            // we're unlinking a catalog - no actual deletion of catalogs in DB 
            var url = deleteCatalogRoute.replace('ID', node.id) + '?parent=' + parent;
            $.ajax({
                    url: url,
                    method: 'POST'
            }).done(function(msg){
                if(msg.success){ tree.delete_node(node.id); }
                else{
                    var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
                    $('#errormessagewinow').empty().append(html);
                    $('#errormessagewinow').dialog('open');
                }
            }).fail(function(){
                var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">Error while deleting the catalog!</td></tr></table>';
                $('#errormessagewinow').empty().append(html);
                $('#errormessagewinow').dialog('open');
            });
        }
        else {  // we're deleting user's own catalogs
            var url = deleteCatalogRoute.replace('ID', node.id);
            $.ajax({
                    url: url,
                    method: 'POST'
            }).done(function(msg){
                if(msg.success){
                    $('#' + node.id + ' > ul').remove();
                    tree.delete_node(node.id);
                }
                else{
                    var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">' + msg.message + '</td></tr></table>';
                    $('#errormessagewinow').empty().append(html);
                    $('#errormessagewinow').dialog('open');
                }
            }).fail(function(){
                var html = '<table><tr><td width="64px"><img src="/o-gis/web/img/stop.png"/></td><td valign="middle">Error while deleting the catalog!</td></tr></table>';
                $('#errormessagewinow').empty().append(html);
                $('#errormessagewinow').dialog('open');
            });
        }
    }
}

// Initializes the tree
function loadUserCatalogs(){
    $.ajax(rootNodes)
        .done(function(msg){
            $('#foldertree').jstree({
                'core' : {
                    'multiple' : false,
                    'data' : msg.catalogs,
                    'check_callback': true
                },
                'types':{
                    "catalog": {icon: "/o-gis/web/img/icons/catalog.png"},
                    "layer": {icon: "/o-gis/web/img/icons/layer.png"},
                    "raster": {icon: "/o-gis/web/img/icons/raster.png"},
                    "line": {icon: "/o-gis/web/img/icons/line.png"},
                    "point": {icon: "/o-gis/web/img/icons/point.png"},
                    "polygon": {icon: "/o-gis/web/img/icons/polygon.png"},
                    "composition": {icon: "/o-gis/web/img/icons/composition.png"},
                    "style": {icon: "/o-gis/web/img/icons/style.png"},
                    "palette": {icon: "/o-gis/web/img/icons/palette.png"},
                    "external": {icon: "/o-gis/web/img/icons/external.png"},
                    "user": {icon: "/o-gis/web/img/icons/user.png"}
                },
		            'plugins': [ "sort", "types", "contextmenu" ],
	             	'sort': function (a, b) {
                    var nodeA = this.get_node(a);
                    var nodeB = this.get_node(b);
                    if (nodeA.type.match(/^catalog/g) && !nodeB.type.match(/^catalog/g)){ return -1; }
                    if (!nodeA.type.match(/^catalog/g) && nodeB.type.match(/^catalog/g)){ return 1; }
                    return this.get_text(a) > this.get_text(b) ? 1 : -1;
                },
                'contextmenu': {items: contextMenuItems}
            }).on('select_node.jstree', function(e, data){
                if (data.event.button === 2 && !data.node.type.match(/^catalog/g)){ return; }
    		        loadCatalogContents(data.node);
            }).on('rename_node.jstree', function(e, data){
                if (data.node.type.match(/^catalog/g)){
                    saveCatalog(data.node);
                }
                else{
                    saveUpdatedLink(data.node);
                }
            });
        })
        .fail(function(){
            $('#foldertree').append('<div class="loaderrormsg"><b>Error while loading data!</b></div>');
        });
}

// Initializes the tree
function loadProjectCatalogs(){
    $.ajax(rootNodes)
        .done(function(msg){
            $('#foldertree').jstree({
                'core' : {
                    'multiple' : false,
                    'data' : msg.catalogs,
                    'check_callback': true
                },
                'types':{
                    "catalog": {icon: "/o-gis/web/img/icons/catalog.png"},
                    "layer": {icon: "/o-gis/web/img/icons/layer.png"},
                    "raster": {icon: "/o-gis/web/img/icons/raster.png"},
                    "line": {icon: "/o-gis/web/img/icons/line.png"},
                    "point": {icon: "/o-gis/web/img/icons/point.png"},
                    "polygon": {icon: "/o-gis/web/img/icons/polygon.png"},
                    "composition": {icon: "/o-gis/web/img/icons/composition.png"},
                    "palette": {icon: "/o-gis/web/img/icons/palette.png"},
                    "style": {icon: "/o-gis/web/img/icons/style.png"},
                    "external": {icon: "/o-gis/web/img/icons/external.png"},
                    "user": {icon: "/o-gis/web/img/icons/user.png"}
                },
		            'plugins': [ "sort", "types", "contextmenu" ],
		            'sort': function (a, b) {
                    var nodeA = this.get_node(a);
                    var nodeB = this.get_node(b);
                    if (nodeA.type.match(/^catalog/g) && !nodeB.type.match(/^catalog/g)){ return -1; }
                    if (!nodeA.type.match(/^catalog/g) && nodeB.type.match(/^catalog/g)){ return 1; }
                    return this.get_text(a) > this.get_text(b) ? 1 : -1;
                },
                'contextmenu': {items: contextMenuItems}
            }).on('select_node.jstree', function(e, data){
                if (data.event.button === 2 && !data.node.type.match(/^catalog/g)){ return; }
    		        loadCatalogContents(data.node);
            }).on('rename_node.jstree', function(e, data){
                if (data.node.type.match(/^catalog/g)){
                    saveCatalog(data.node);
                }
                else{
                    saveUpdatedLink(data.node);
                }
            });
        })
        .fail(function(){
            $('#foldertree').append('<div class="loaderrormsg"><b>Error while loading data!</b></div>');
        });
}
