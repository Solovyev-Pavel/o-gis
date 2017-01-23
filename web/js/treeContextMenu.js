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
  *                         Supplements catalogTree.js                         *
  * ************************************************************************** */
  
  // flags:
// f -> can favorite                n -> can create subcatalogs       
// r -> can rename                  m -> can move (~ cut, copy)
// p -> can paste into              s -> settings
// d -> can delete                  u -> can unlink (favorited catalog)

function contextMenuItems(node){
    var item_type = (node.type === 'catalog') ? 'catalog' : 'link';
    var flags = node.original.flags;
    var items = {};
    if (flags === '' || flags === null){ return items; }
    // adding to favorites
    if (flags.match(/f/i)){
        items.favItem = {       label: "Add To Favorites",
                                action: function(){ addToFavorites(node); },
                                icon: "./img/icons/fav.png"      }; 
    }
    // creating new catalog inside the current one
    if (flags.match(/n/i)){
        items.createItem = {
                                label: "Create Child Catalog",
                                action: function(){ createCatalog(node); },
                                icon: "./img/icons/add.png"     };
    }
    // renaming
    if (flags.match(/r/i)){
        items.renameItem = {    // rename selected node | affects only links, not actual objects behind it
                                label: "Rename",
                                action: function(){ renameCatalog(node); },
                                icon: "./img/icons/edit.png"    };
    }
    // moving
    if (flags.match(/m/i)){
        items.copyItem = {      // copy a node
                                label: "Copy",
                                action: function(){ copyNode(node, true); },
                                icon: "./img/icons/copy.png"     };
        items.cutItem = {       // cut a node
                                label: "Cut",
                                action: function(){ copyNode(node, false); },
                                icon: "./img/icons/cut.png"       };
    }
    // pasting into
    if (flags.match(/p/i) && copyBuffer !== null){
        items.pasteItem = {     // paste a node
                                label: "Paste",
                                action: function(){ pasteNode(node);   },
                                icon: "./img/icons/paste.png" };
    }
    // properties
    if (flags.match(/s/i)){
        items.propertiesItem = {
                                label: "Catalog settings",
                                action: function(){ editCatalogProperties(node); },
                                icon: "./img/icons/properties.png"      };
    }
    // deleting
    if (flags.match(/d/i) || flags.match(/u/i)){
        items.deleteItem = {   // delete current node | affects only links, not actual objects behind it
                                label: "Delete " + item_type,
                                action: function() { deleteNode(node);  },
                                icon: "./img/icons/delete.png" };
    }
    return items;
}