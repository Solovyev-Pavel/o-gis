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
 *         This is the 'home' object of the O-GIS composition editor          *
 *                                                                            *
 * Dependencies:                                                              *
 *  - HTML5 and CSS3                                                          *
 *  - OpenLayers 2.* by OpenGeo                                               *
 *  - jQuery 2.0+                                                             *
 *  - jQuery UI                                                               *
 *  - jQuery-minicolors by Cory LaViska                                       *
 *  - jQuery-contextMenu by B. Brala, R. Rehm, C. Baartse, A. Osmani          *
 * ************************************************************************** */

function CompositionEditor(){
    this.map = null;                // OpenLayers map entity
    this.composition = null;        // defined in CompositionObject.js
    this.cmpBackUp = null;          // backup of the composition in works
    this.AddLayers = null;          // defined in AddLayer.js
    this.Authorize = null;          // defined in Authorize.js
    this.CompositionSave = null;    // defined in CompositionSave.js
    this.LayerStyler = null;        // defined in Styler.js
    this.RasterAnalysis = null;     // defined in RasterAnalysis.js
    this.WMSFeatureInfo = null;     // defined in WMSInfo.js
    
    // list of params the Composition Editor starts with:
    this.params = {
        thisVar: '',                // name of this variable; necessary, unfortunately
        mapDOM: '',                 // DOM element where the map will be displayed
        layerListDOM: '',           // DOM containing the list of the layers
        addLayerWindow: '',         // DOM of a window in which the list of available layers is displayed
        addCmpWindow: '',           // DOM of a window used during adding of a composition
        authWindow: '',             // DOM of a window used for user authentification
        saveCmpWindow: '',          // DOM of a window used during saving the composition
        stylerWindow: '',           // DOM of a window used for styling layers
        selectPaletteWindow: '',    // DOM of a window used for selecting a raster palette
        rasterOpWindow: '',         // DOM of a window used for Raster Analysis interface
        selectRasterWindow: '',     // DOM of a window used for selecting a raster layer
        coordOutputDiv: '',         // DOM for cursor coordinate output
        waitAnimBox: ''             // DOM to be displayed while raster operation is being processed
    };
    
    // Object with the data about the current user
    this.user = null;

// -------------------------------------------------------------------------- //

    // Sets the variable name of the ComposirionEditor class object
    this.setVariable = function(variable){ this.params.thisVar = variable; };
    
    // Sets the id of the DOM element, in which the map will be displayer
    this.setMapDOM = function(id){ this.params.mapDOM = id; };
    
    // Sets the id of the DOM element in which the list of the layers is displayed
    this.setLayerListDOM = function(id){ this.params.layerListDOM = id; };
    
    // Sets the id of the DOM used for displaying "Add Layer" window
    this.setAddLayerWindow = function(id){ this.params.addLayerWindow = id; };
    
    // Sets the id of the DOM used for displaying "Add Composition" window
    this.setAddCompositionWindow = function(id){ this.params.addCmpWindow = id; };
    
    // Sets the id of the DOM of a window used for user authentification
    this.setAuthentificationWindow = function(id){ this.params.authWindow = id; };
    
    // Sets the id of the DOM of a window used during saving the composition
    this.setSaveCompositionWindow = function(id){ this.params.saveCmpWindow = id; };
    
    // Sets the id of the DOM of a window used for styling layers
    this.setStylerWindow = function(id){ this.params.stylerWindow = id; };
    
    // Sets the id of the DOM of a window used for selecting a raster palette
    this.setPaletteSelectWindow = function(id){ this.params.selectPaletteWindow = id; };
    
    // Sets the id of the DOM of a window used for Raster Analysis interface
    this.setRasterOpWindow = function(id){ this.params.rasterOpWindow = id; };
    
    // Sets the id of the DOM of a window used for selecting a raster layer
    this.setSelectRasterWindow = function(id){ this.params.selectRasterWindow = id; };
    
    // Sets the cursour position output DOM
    this.setCursorPositionDom = function(id){ this.params.coordOutputDiv = id; };
    
    // Sets DOM to be displayed while raster operation is being processed
    this.setWaitAnimDom = function(id){ this.params.waitAnimBox = id; };
    
    this.setUser = function(id, name){
        this.user = { id: id, name: name, favRoot: "/o-gis/web/app.php/catalog/user/" + id, can_overwrite: false, limit: 0 };
    };
    this.setUser = function(id, name, limit){
        this.user = { id: id, name: name, favRoot: "/o-gis/web/app.php/catalog/user/" + id, can_overwrite: false, limit: limit };
    };
    
    // Set user's permission to edit composition he isn't an author of
    this.setEditPermission = function(value){
        if (this.user === null){ return; }
        this.user.can_overwrite = (value === 1) ? true : false;
    };
    
    // Get the information about the current user
    this.getUser = function(){ return this.user; };
    
// -------------------------------------------------------------------------- //
    
    // Load the initial layer / composition into the Composition Editor
    this.initializeCompositionEditor = function (type, id){
        this.initializeSubClasses();
        // if we have something to load, load it
        if (type !== null && id !== null){ this.loadObject(type, id); }
        // otherwise, we're done
    };
    
    // Load objects
    this.loadObject = function(type, id){
        var c_editor = this;
        var url = (type === 'layer') ? getLayerData : getCompositionData;
        $.ajax({url: url.replace(/ID/g, id), method: 'GET'})
            .done(function(msg){
                if (!msg.success){
                    $( "#messagewindow" ).empty();
                    var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                                msg.msg + '</td></tr></table>';
                    $( "#messagewindow" ).append(html);
                    $( "#messagewindow" ).dialog("open");
                    return;
                }
                if (type === 'layer'){ id = null; }
                if (msg.maxExtent === undefined || msg.maxExtent === null){ msg.maxExtent = msg.data.extent; }
                c_editor.initializeComposition(msg.data, id, msg.maxExtent);
                c_editor.initializeMap();
            })
            .fail(function(){
                $( "#messagewindow" ).empty();
                var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td><td valign="middle">' +
                            'Ошибка при загрузке данных!</td></tr></table>';
                $( "#messagewindow" ).append(html);
                $( "#messagewindow" ).dialog("open");
                return;
            });
    };

    // Initialize the composition object
    this.initializeComposition = function(data, id, maxExtent){
        this.composition = new Composition();
        this.composition.authors = data.authors;
        this.composition.layers = data.layers;
        this.composition.extent = data.extent;
        this.composition.maxExtent = maxExtent;
        this.composition.id = id;
        this.composition.name = data.name;
        this.composition.description = data.description;
        this.composition.projection = data.projection;
    };

    // Initialize the Composition Editor sub classes
    this.initializeSubClasses = function(){
        this.AddLayers = new CompositionEditorAddLayers();
        this.AddLayers.setParent(this);
        this.Authorize = new CompositionEditorAuthenticate();
        this.Authorize.setParent(this);
        this.CompositionSave = new CompositionEditorCompositionSave();
        this.CompositionSave.setParent(this);
        this.LayerStyler = new CompositionEditorLayerStyler();
        this.LayerStyler.setParent(this);
        this.RasterAnalysis = new CompositionEditorRasterAnalysis();
        this.RasterAnalysis.setParent(this);
        this.WMSFeatureInfo = new CompositionEditorWMSFeatureInfo();
        this.WMSFeatureInfo.setParent(this);
    };

    // Initialize the map
    this.initializeMap = function(){
        // back up the composition
        this.cmpBackUp = this.composition;
        // base settings of the OL2 map
        this.map = new OpenLayers.Map(this.params.mapDOM, { projection: new OpenLayers.Projection(this.composition.projection) });
        this.map.parent = this;
        this.map.addControl(new OpenLayers.Control.Navigation());
        this.map.maxExtent = new OpenLayers.Bounds(this.composition.maxExtent.minX, this.composition.maxExtent.minY,
                                                   this.composition.maxExtent.maxX, this.composition.maxExtent.maxY);
        this.map.maxResolution = (this.composition.maxExtent.maxX - this.composition.maxExtent.minX) / 256;
        // add the WMS Feature Info button to the map
        var c_editor = this;
        var activateWMSInfoFeature = function(){ c_editor.WMSFeatureInfo.WMSFeatureInfoSwitcher(); };
        var infoButton = new OpenLayers.Control.Button({ title: "Feature Info",
                                                         displayClass: "olfibutton",
                                                         trigger: activateWMSInfoFeature });
        var panel = new OpenLayers.Control.Panel({ defaultControl: infoButton });
        panel.addControls([infoButton]);
        this.map.addControl(panel);
        // start adding layers - empty base layer first
        var baseLayer = new OpenLayers.Layer("Empty base layer", {isBaseLayer: true, displayInLayerSwitcher: false});
        this.map.addLayers([baseLayer]);
        // begin outputing coordinates
        if (document.getElementById(this.params.coordOutputDiv)){
            var dom = document.getElementById(this.params.coordOutputDiv);
            this.map.addControl(new OpenLayers.Control.MousePosition({element: dom}));
        }
        // start adding layers - composition layers
        for (var i = 0; i < this.composition.layers.length; i++){
            var target = new OpenLayers.Layer.WMS(
                    this.composition.layers[i].name,
                    "/o-gis/web/app.php/wms", {
                        LAYERS: this.composition.layers[i].workspace + ':' + this.composition.layers[i].cs,
                        format: 'image/png',
                        transparent: true
                    }, {
                        projection: this.composition.projection,
                        wrapDateLine: false,
                        displayOutsideMaxExtent: false
                    }, {
                        singleTile: false,
                        ratio: 1,
                        isBaseLayer: false,
                        displayInLayerSwitcher: true
                    });
            if (target.params.SRS === undefined){ target.params.SRS = this.composition.projection; }
            target.setOpacity(this.composition.layers[i].transp);
            target.setVisibility(this.composition.layers[i].vis);
            if (this.composition.layers[i].style.type === 'sld'){
                delete target.params.STYLES;
                target.mergeNewParams({sld_body: this.composition.layers[i].style.value.replace(/\\"/gi, '"')});
            }
            else { target.mergeNewParams({styles: this.composition.layers[i].style.value}); }
            this.map.addLayers([target]);
            this.addLayerToTheList(this.composition.layers[i].name, target.id, this.composition.layers[i].vis);
        }
        if (this.composition.extent.type === 'bb'){
            this.map.zoomToExtent(new OpenLayers.Bounds(this.composition.extent.minX,
                                                        this.composition.extent.minY,
                                                        this.composition.extent.maxX,
                                                        this.composition.extent.maxY), false);
        }
        else {
            this.map.setCenter(new OpenLayers.LonLat(this.composition.extent.centerx,
                                                     this.composition.extent.centery),
                               this.composition.extent.zoomlevel, false, false);
        }
    };
    
    // Adds a layer to the user-visible list
    this.addLayerToTheList = function(name, id, visibility){
        var c_editor = this;
        var li_text =   '<li id="menu-' + id + '" class="ui-state-default sortableelement"><span class="sortableelementinner">' +
                        '<input type="checkbox" onclick="' + this.params.thisVar + '.toggleLayerVisibility(\'' + id + 
                        '\', this.checked)"';
        li_text += (visibility) ? 'checked />' : '/>';
        li_text +=  '</span><div id="wmsinfo-' + id + '" onclick="' + this.params.thisVar +
                    '.WMSFeatureInfo.toggleWMSInfoLayer(this.id);" class="notwmsselectedlayer">' + name + '</div></li>';

        $('#' + this.params.layerListDOM).prepend(li_text);
        $.contextMenu({
            selector: '#menu-' + id,
            items: {
                "style":    {   name: "Stylization options",
                                icon: "edit",
                                callback: function(key, opt){ c_editor.LayerStyler.styleLayer(opt.selector); } },
                "addtofav": {   name: "Add layer to favorites",
                                icon: "cut",
                                callback: function(){ 
                                    var fullcs = c_editor.map.getLayer(id).params.LAYERS;
                                    c_editor.getLayersInternalId(fullcs); } },
                "remove":   {   name: "Remove from composition",
                                icon: "delete",
                                callback: function(key, opt){ c_editor.removeLayerFromComposition(opt.selector); } }
            }
        });
    };
    
    // Updates the layer order
    this.updateLayerOrder = function(){
        var nodes = $('#' + this.params.layerListDOM).children();
        for (var i = 0; i < nodes.length; i++){
            var layer_id = nodes[i].getAttribute('id').substring(5);
            this.map.getLayer(layer_id).setZIndex(nodes.length - i);
        }
    };
    
    // Gets a layer's internal id
    this.getLayersInternalId = function(cs){
        if (this.user === null){
            var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td>' +
                        '<td valign="middle">Only authenticated users can add to favorites!</td></tr></table>';
            $( "#messagewindow" ).dialog('option', 'title', 'Adding to favorites');
            $( "#messagewindow" ).empty().append(html);
            $( "#messagewindow" ).dialog('open');
            return;
        }
        var justcs = cs.substring(cs.indexOf(':') + 1);
        $.ajax({
            url: getLayerId.replace('ID', justcs)
        }).done(function(msg){
            showTargetCatalogTree(msg.id, 'layer');
        });
    };
    
    // Toggles the visibility of a layer
    this.toggleLayerVisibility = function(id, visible){ this.map.getLayer(id).setVisibility(visible); };
    
    // Removes a layer from the list and from the map
    this.removeLayerFromComposition = function(entity){
        var layer_id = entity.substring(6);
        this.map.removeLayer(this.map.getLayer(layer_id));
        $(entity).remove();
    };
    
    // Leave the editor
    this.goToEntity = function(type, id){ window.location.href = "/o-gis/web/app.php/" + type + "/" + id; };
    
    // Hide / show the list of the layers
    this.toggleLayerListVisibility = function(){
        var stateOpen = ($('#layerlistpanel').css('display') !== 'none') ? true : false;
        if (stateOpen){
            $('#layerlistpanel').css('display', 'none');
            $('#mappanelmain').css('width', 'calc(100% - 15px)');
            $('#listvisibilitytoggler').prop('title', 'Show the Layer List');
        }
        else{
            $('#layerlistpanel').css('display', 'block');
            $('#mappanelmain').css('width', 'calc(100% - 255px)');
            $('#listvisibilitytoggler').prop('title', 'Hide the Layer List');
        }
        this.map.updateSize();
    };
    
    // Update map size on window resizing
    this.adjustMapSize = function(){
        var stateOpen = ($('#layerlistpanel').css('display') !== 'none') ? true : false;
        if (stateOpen){
            $('#mappanelmain').css('width', 'calc(100% - 15px)');
            $('#mappanelmain').css('height', '100%');
        }
        else{
            $('#mappanelmain').css('width', 'calc(100% - 255px)');
            $('#mappanelmain').css('height', '100%');
        }
        this.map.updateSize();
    };
    
    // Add composition to favorites
    this.addCompositionToFavorites = function(){
        if (this.user === null){
            var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td>' +
                        '<td valign="middle">Only authenticated users can add to favorites!</td></tr></table>';
            $( "#messagewindow" ).dialog('option', 'title', 'Adding to favorites');
            $( "#messagewindow" ).empty().append(html);
            $( "#messagewindow" ).dialog('open');
            return;
        }
        if (this.composition.id === null){
            var html =  '<table><tr><td width="64px"><img src="/o-gis/web/img/error.png"/></td>' +
                        '<td valign="middle">This composition isn\'t saved yet. You can\'t add it to your favorites!' +
                        '</td></tr></table>';
            $( "#messagewindow" ).dialog('option', 'title', 'Adding to favorites');
            $( "#messagewindow" ).empty().append(html);
            $( "#messagewindow" ).dialog('open');
            return;
        }
        showTargetCatalogTree(this.composition.id, 'composition');
    };
    
}
