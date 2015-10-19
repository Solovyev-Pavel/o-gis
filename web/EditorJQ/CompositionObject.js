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
 *                        This is the composition entity                      *
 * ************************************************************************** */


function Composition(){
    this.authors = new Array();
    this.description = null;
    this.extent = new Object();
    this.id = null;
    this.layers = new Array();
    this.name = null;
    this.populated = false;
    this.projection = null;

    // Composition is populated?
    this.SetPopulated = function(populated){ this.populated = populated; };

    // Setters for base properties
    this.SetDescription = function(description){ this.description = description; };
    this.SetId = function(id){ this.id = id; };
    this.SetName = function(name){ this.name = name; };
    this.SetProjection = function(projection){ this.projection = projection; };

    // Add a layer into the composition
    this.AddLayer = function(layerobject){
        var layer = new Object();
        layer.cs = layerobject.cs;
        layer.workspace = layerobject.workspace;
        layer.name = layerobject.name;
        layer.projection = layerobject.projection;
        layer.vis = true;
        layer.transp = 1.0;
        layer.source = null;
        layer.type = (layerobject.type !== undefined && layerobject.type !== null) ? layerobject.type : null ;
        layer.style = { "type": "id", "value": "" };
        this.layers.push(layer);
    };

    // Update layer projection
    this.LayerAddProjection = function(cs, proj){
        for (var i = 0; i < this.layers.length; i++){
            if (this.layers[i].cs === cs){
                this.layers[i].projection = proj;
                return;
            }
        }
    };

    // Add an author for the composition
    this.AddAuthor = function(id, name){
        var author = new Object();
        author.id = id;
        author.name = name;
        var len = this.authors.length;
        for (var i = 0; i < len; i++){
            if( this.authors[i].id === id ){ return; }
        }
        this.authors[len] = author;
    };

    // Set compositon extents
    this.SetExtent = function(extent){ this.extent = extent; };
    this.SetExtent = function(left, bottom, right, top){
        var extent = new Object();
        extent.minX = left;
        extent.minY = bottom;
        extent.maxX = right;
        extent.maxY = top;
        extent.type = "bb";
        this.extent = extent;
    };

    // Load whole composition from a JSON string
    this.FillFromJSON = function(jsonString){
        jsonString = jsonString.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '\"');
        var loadedCmp = JSON.parse(jsonString);
        this.authors = loadedCmp.authors;
        this.extent = loadedCmp.extent;
        this.layers = loadedCmp.layers;
        this.populated = true;
    };

    // Load whole composition (sans authors) from OpenLayers
    this.FillFromOL = function(map){
        var olextent = map.getExtent();
        var extent = new Object();
        extent.minX = olextent.left;
        extent.minY = olextent.bottom;
        extent.maxX = olextent.right;
        extent.maxY = olextent.top;
        extent.type = "bb";
        this.extent = extent;

        var maplayers = map.layers;
        var layers = new Array();
        maplayers.sort(function(a, b){ return a.getZIndex() - b.getZIndex(); });
        for (var i = 1; i <= maplayers.length; i++){
            var layer = new Object();
            layer.cs = map.layers[i].params.LAYERS;
            layer.name = map.layers[i].name;
            layer.source = (map.layers[i].url === app.sources.local.url) ? "local" : map.layers[i].url;
            layer.projection = map.layers[i].params.SRS;
            layer.name = map.layers[i].name;
            layer.vis = map.layers[i].visibility;
            layer.type = null;
            layer.transp = map.layers[i].opacity;
            var style = new Object();
            style.type = map.layers[i].params.SLD_BODY === undefined ? "id" : "sld";
            if (style.type === "id"){
                style.value = map.layers[i].params.STYLES;
            }
            else{
                style.value = map.layers[i].params.SLD_BODY;
            }
            layer.style = style;
            layers[i] = layer;
        }
        this.layers = layers;
        this.populated = true;
    };

    // Adds information about the layer's min, max and nodata values
    this.AddLayerMinMaxNoData = function(cs, min, max, nodata){
        for (var i = 0; i < this.layers.length; i++){
            if (this.layers[i].cs === cs){
                var gvalues = new Object;
                gvalues.min = min;
                gvalues.max = max;
                gvalues.nodata = nodata;
                this.layers[i].gridvalues = gvalues;
                return;
            }
        }
    };

    // Checks if user is an author of the composition
    this.isAuthor = function(id){
        var len = this.authors.length;
        for (var i = 0; i < len; i++){
            if( this.authors[i].id === id ){ return true; }
        }
        return false;
    };

    // Gets information about the layer's min, max and nodata values
    this.getLayerMinMaxNodata = function(cs){
        if (/\:/gi.test(cs)){
            cs = cs.substring(cs.indexOf(':') + 1);
        }
        for (var i = 0; i < this.layers.length; i++){
            if (this.layers[i].cs === cs){
                if (this.layers[i].gridvalues !== undefined){
                    return this.layers[i].gridvalues;
                }
            }
        }
        return {min: -9999, max: -9999, nodata: -9999};
    };

    // Set layer type
    this.setLayerType = function(cs, type){
        for (var i = 0; i < this.layers.length; i++){
            if (this.layers[i].cs === cs){
                this.layers[i].type = type;
            }
        }
    };


    // Get layer type
    this.getLayerType = function(cs){
        for (var i = 0; i < this.layers.length; i++){
            if (this.layers[i].cs === cs){
                if (this.layers[i].type !== undefined && this.layers[i].type !== null){
                    return this.layers[i].type;
                }
            }
        }
        return null;
    };
}
