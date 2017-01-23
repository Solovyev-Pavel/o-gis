<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\DefaultController::homePageAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/auth/login')) {
            // login
            if ($pathinfo === '/auth/login') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AuthManagerController::loginFromSiteAction',  '_route' => 'login',);
            }

            // validatelogin
            if ($pathinfo === '/auth/login_validate') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_validatelogin;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AuthManagerController::credentialsCheckForLoginAction',  '_route' => 'validatelogin',);
            }
            not_validatelogin:

        }

        if (0 === strpos($pathinfo, '/user')) {
            // showuser
            if (preg_match('#^/user/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'showuser')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\UserController::showUserAction',));
            }

            // userlist
            if ($pathinfo === '/users') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\UserController::userListAction',  '_route' => 'userlist',);
            }

        }

        // userlistitems
        if ($pathinfo === '/list/users') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\UserController::userListItemsAction',  '_route' => 'userlistitems',);
        }

        // usernotes
        if (0 === strpos($pathinfo, '/user/notes') && preg_match('#^/user/notes/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'usernotes')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\UserController::editUserNotesAction',));
        }

        if (0 === strpos($pathinfo, '/message')) {
            // usermessages
            if ($pathinfo === '/messagebox') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\MessageController::GetMessagesAction',  '_route' => 'usermessages',);
            }

            // viewmessage
            if (0 === strpos($pathinfo, '/message/view') && preg_match('#^/message/view(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'viewmessage')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\MessageController::ViewMessageAction',  'id' => NULL,));
            }

        }

        // sendmessage
        if ($pathinfo === '/send/message') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_sendmessage;
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\MessageController::SendMessageAction',  '_route' => 'sendmessage',);
        }
        not_sendmessage:

        // markasread
        if (0 === strpos($pathinfo, '/message/read') && preg_match('#^/message/read(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_markasread;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'markasread')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\MessageController::MarkAsReadAction',  'id' => NULL,));
        }
        not_markasread:

        if (0 === strpos($pathinfo, '/catalog')) {
            // loadusercatalogs
            if (0 === strpos($pathinfo, '/catalog/user') && preg_match('#^/catalog/user/(?P<holderid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'loadusercatalogs')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::loadUserCatalogsAction',));
            }

            // loaduserandglobalcatalogs
            if ($pathinfo === '/catalog/globaltree') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::loadGlobalCatalogsAction',  '_route' => 'loaduserandglobalcatalogs',);
            }

            // loadprojectcatalogs
            if (0 === strpos($pathinfo, '/catalog/project') && preg_match('#^/catalog/project/(?P<catid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'loadprojectcatalogs')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::loadProjectCatalogAction',));
            }

            // loadcatalogdata
            if (0 === strpos($pathinfo, '/catalog/data') && preg_match('#^/catalog/data/(?P<catid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'loadcatalogdata')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::loadCatalogDataAction',));
            }

            // loadcatalogdataeditor
            if (0 === strpos($pathinfo, '/catalog/layers') && preg_match('#^/catalog/layers/(?P<catid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'loadcatalogdataeditor')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::loadCatalogDataEditorAction',));
            }

            // loadsubcatalogs
            if (0 === strpos($pathinfo, '/catalog/children') && preg_match('#^/catalog/children/(?P<catid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'loadsubcatalogs')), array (  '_contorller' => 'OGISIndexBundle:Catalog:loadCatalogChildren',));
            }

            // savecatalog
            if ($pathinfo === '/catalog/save') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_savecatalog;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::modifyCatalogAction',  '_route' => 'savecatalog',);
            }
            not_savecatalog:

        }

        // updatelink
        if ($pathinfo === '/link/save') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_updatelink;
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::modifyLinkAction',  '_route' => 'updatelink',);
        }
        not_updatelink:

        // deletecatalog
        if (0 === strpos($pathinfo, '/catalog/delete') && preg_match('#^/catalog/delete/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_deletecatalog;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletecatalog')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::deleteCatalogAction',));
        }
        not_deletecatalog:

        if (0 === strpos($pathinfo, '/edit')) {
            if (0 === strpos($pathinfo, '/edit/catalog')) {
                // editcatalog
                if (preg_match('#^/edit/catalog/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'editcatalog')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::editCatalogAction',));
                }

                // editcatalog_save
                if (0 === strpos($pathinfo, '/edit/catalog/save') && preg_match('#^/edit/catalog/save/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_editcatalog_save;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'editcatalog_save')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::updateCatalogAction',));
                }
                not_editcatalog_save:

            }

            // updatecatalogacl
            if (0 === strpos($pathinfo, '/edit/acl/catalog') && preg_match('#^/edit/acl/catalog/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_updatecatalogacl;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'updatecatalogacl')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::updateAclAction',));
            }
            not_updatecatalogacl:

        }

        // movecatalogentity
        if ($pathinfo === '/move/catalog') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_movecatalogentity;
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::changeParentAction',  '_route' => 'movecatalogentity',);
        }
        not_movecatalogentity:

        if (0 === strpos($pathinfo, '/l')) {
            // layerlist
            if (0 === strpos($pathinfo, '/layers') && preg_match('#^/layers(?:/(?P<sortby>[^/]++)(?:/(?P<page>[^/]++))?)?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'layerlist')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::showListAction',  'sortby' => 'modified',  'page' => 1,));
            }

            if (0 === strpos($pathinfo, '/list')) {
                // showlayerlist
                if (0 === strpos($pathinfo, '/list/layers') && preg_match('#^/list/layers(?:/(?P<group>[^/]++))?$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'showlayerlist')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::layerListForAddFunctionAction',  'group' => 'user',));
                }

                if (0 === strpos($pathinfo, '/list/rasters')) {
                    // showrasterlist
                    if ($pathinfo === '/list/rasters') {
                        return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::rasterListFunctionAction',  '_route' => 'showrasterlist',);
                    }

                    // showrasterlisteditor
                    if ($pathinfo === '/list/rasters_editor') {
                        return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::rasterListEditorFunctionAction',  '_route' => 'showrasterlisteditor',);
                    }

                }

            }

            // showlayer
            if (0 === strpos($pathinfo, '/layer') && preg_match('#^/layer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'showlayer')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::showLayerAction',));
            }

        }

        // createlayer
        if ($pathinfo === '/create/layer') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::createLayerAction',  '_route' => 'createlayer',);
        }

        if (0 === strpos($pathinfo, '/upload')) {
            // layer_upload
            if ($pathinfo === '/upload/layer') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_layer_upload;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::uploadLayerAction',  '_route' => 'layer_upload',);
            }
            not_layer_upload:

            // upload_successful
            if (0 === strpos($pathinfo, '/upload/complete') && preg_match('#^/upload/complete/(?P<layername>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'upload_successful')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::uploadCompleteAction',));
            }

            // upload_failed
            if ($pathinfo === '/upload/failed') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::uploadFailedAction',  '_route' => 'upload_failed',);
            }

        }

        // layerdlcounter
        if (0 === strpos($pathinfo, '/dllayer') && preg_match('#^/dllayer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_layerdlcounter;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'layerdlcounter')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::updateDLCounterAction',));
        }
        not_layerdlcounter:

        // edit_layer_properties
        if (0 === strpos($pathinfo, '/edit/layer') && preg_match('#^/edit/layer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'edit_layer_properties')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::editLayerPropertiesAction',));
        }

        // get_layer_id
        if (0 === strpos($pathinfo, '/find/layer') && preg_match('#^/find/layer/(?P<cs>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_layer_id')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::findLayerByConStringAction',));
        }

        // edit_layer_properties_save
        if (0 === strpos($pathinfo, '/edit/layer/save') && preg_match('#^/edit/layer/save/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_edit_layer_properties_save;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'edit_layer_properties_save')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::saveLayerPropertiesAction',));
        }
        not_edit_layer_properties_save:

        if (0 === strpos($pathinfo, '/delete')) {
            // deletelayerconfirm
            if (0 === strpos($pathinfo, '/deleteconfirm/layer') && preg_match('#^/deleteconfirm/layer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletelayerconfirm')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::deleteLayerConfirmAction',));
            }

            if (0 === strpos($pathinfo, '/deletelayer')) {
                // deletelayer
                if (preg_match('#^/deletelayer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletelayer')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::deleteLayerAction',));
                }

                // deletelayersuccess
                if (0 === strpos($pathinfo, '/deletelayer/success') && preg_match('#^/deletelayer/success/(?P<layername>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletelayersuccess')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::deleteLayerSuccessAction',));
                }

            }

        }

        // layerstylingoptions
        if ($pathinfo === '/list/styling') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::stylingOptionsPageAction',  '_route' => 'layerstylingoptions',);
        }

        // getLayerData
        if (0 === strpos($pathinfo, '/get/layer') && preg_match('#^/get/layer/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getLayerData')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::getLayerDataAction',));
        }

        // showcomposition
        if (0 === strpos($pathinfo, '/composition') && preg_match('#^/composition/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'showcomposition')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::showCompositionAction',));
        }

        // getCompositionData
        if (0 === strpos($pathinfo, '/get/composition') && preg_match('#^/get/composition/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getCompositionData')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::getCompositionDataAction',));
        }

        // saveComposition
        if (0 === strpos($pathinfo, '/savecomposition') && preg_match('#^/savecomposition(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'saveComposition')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::saveCompositionAction',  'id' => NULL,));
        }

        if (0 === strpos($pathinfo, '/edit/composition')) {
            // edit_composition_properties
            if (preg_match('#^/edit/composition/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'edit_composition_properties')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::editCompositionPropertiesAction',));
            }

            // edit_composition_properties_save
            if (0 === strpos($pathinfo, '/edit/composition/save') && preg_match('#^/edit/composition/save/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_edit_composition_properties_save;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'edit_composition_properties_save')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::saveCompositionPropertiesAction',));
            }
            not_edit_composition_properties_save:

        }

        if (0 === strpos($pathinfo, '/deleteco')) {
            // deletecompositionconfirm
            if (0 === strpos($pathinfo, '/deleteconfirm/composition') && preg_match('#^/deleteconfirm/composition/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletecompositionconfirm')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::deleteCompositionConfirmAction',));
            }

            if (0 === strpos($pathinfo, '/deletecomposition')) {
                // deletecomposition
                if (preg_match('#^/deletecomposition/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletecomposition')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::deleteCompositionAction',));
                }

                // deletecompositionsuccess
                if (0 === strpos($pathinfo, '/deletecomposition/success') && preg_match('#^/deletecomposition/success/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletecompositionsuccess')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CompositionController::deleteCompositionSuccessAction',));
                }

            }

        }

        // showproject
        if (0 === strpos($pathinfo, '/project') && preg_match('#^/project/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'showproject')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::showProjectAction',));
        }

        // createproject
        if ($pathinfo === '/create/project') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::createProjectAction',  '_route' => 'createproject',);
        }

        if (0 === strpos($pathinfo, '/generate')) {
            // generate_project
            if ($pathinfo === '/generate/project/') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_generate_project;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::generateProjectAction',  '_route' => 'generate_project',);
            }
            not_generate_project:

            // generate_success
            if (0 === strpos($pathinfo, '/generate/success') && preg_match('#^/generate/success/(?P<projectid>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'generate_success')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::generateProjectCompleteAction',));
            }

        }

        // edit_project_properties
        if (0 === strpos($pathinfo, '/edit/project/properties') && preg_match('#^/edit/project/properties/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'edit_project_properties')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::editProjectPropertiesAction',));
        }

        if (0 === strpos($pathinfo, '/project')) {
            // edit_project_properties_save
            if (0 === strpos($pathinfo, '/project/properties/save') && preg_match('#^/project/properties/save/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_edit_project_properties_save;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'edit_project_properties_save')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::saveProjectPropertiesAction',));
            }
            not_edit_project_properties_save:

            // update_project_notes
            if (0 === strpos($pathinfo, '/project/notes') && preg_match('#^/project/notes/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'update_project_notes')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::editProjectNotesAction',));
            }

        }

        // edit_project_members
        if (0 === strpos($pathinfo, '/edit/project/members') && preg_match('#^/edit/project/members/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'edit_project_members')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::editProjectMembersAction',));
        }

        if (0 === strpos($pathinfo, '/project/members')) {
            // add_project_member
            if ($pathinfo === '/project/members/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_add_project_member;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::addProjectMembersAction',  '_route' => 'add_project_member',);
            }
            not_add_project_member:

            // remove_project_member
            if ($pathinfo === '/project/members/remove') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_remove_project_member;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::removeProjectMembersAction',  '_route' => 'remove_project_member',);
            }
            not_remove_project_member:

            // change_member_rank
            if ($pathinfo === '/project/members/changerank') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_change_member_rank;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::changeProjectMembersRankAction',  '_route' => 'change_member_rank',);
            }
            not_change_member_rank:

        }

        if (0 === strpos($pathinfo, '/delete')) {
            // deleteprojectconfirmation
            if (0 === strpos($pathinfo, '/deleteconfirm/project') && preg_match('#^/deleteconfirm/project/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteprojectconfirmation')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::deleteProjectConfirmAction',));
            }

            if (0 === strpos($pathinfo, '/deleteproject')) {
                // deleteproject
                if (preg_match('#^/deleteproject/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteproject')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::deleteProjectAction',));
                }

                // deleteprojectdone
                if (0 === strpos($pathinfo, '/deleteproject/success') && preg_match('#^/deleteproject/success/(?P<projectname>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deleteprojectdone')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProjectController::deleteProjectSuccessAction',));
                }

            }

        }

        // wmsproxy
        if ($pathinfo === '/wms') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProxyController::wmsProxyAction',  '_route' => 'wmsproxy',);
        }

        // geoserverFunctionsProxy
        if (0 === strpos($pathinfo, '/geoserver') && preg_match('#^/geoserver/(?P<something>[^/]++)(?:/(?P<other>[^/]++))?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'geoserverFunctionsProxy')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProxyController::geoserverFunctionsProxyAction',  'other' => NULL,));
        }

        // geoserverIdentifyForwarder
        if ($pathinfo === '/proxy') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProxyController::geoserverIdentifyForwarderAction',  '_route' => 'geoserverIdentifyForwarder',);
        }

        // corsProxyAny
        if ($pathinfo === '/anyproxy') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\ProxyController::corsProxyAnyAction',  '_route' => 'corsProxyAny',);
        }

        // showstyle
        if (0 === strpos($pathinfo, '/style') && preg_match('#^/style/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'showstyle')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::showStyleAction',));
        }

        // stylelistpage
        if ($pathinfo === '/list/styles') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::listStylesAction',  '_route' => 'stylelistpage',);
        }

        if (0 === strpos($pathinfo, '/create/style')) {
            // createstyle
            if ($pathinfo === '/create/style') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::createStyleAction',  '_route' => 'createstyle',);
            }

            // createstyleraster
            if ($pathinfo === '/create/style/raster') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::createRasterStyleAction',  '_route' => 'createstyleraster',);
            }

        }

        // uploadstyle
        if ($pathinfo === '/upload/style') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_uploadstyle;
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::uploadStyleAction',  '_route' => 'uploadstyle',);
        }
        not_uploadstyle:

        // getstylelist
        if ($pathinfo === '/get/styles') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::getStyleListAction',  '_route' => 'getstylelist',);
        }

        if (0 === strpos($pathinfo, '/apply')) {
            // applystyle
            if ($pathinfo === '/apply/style') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::applyStyleAction',  '_route' => 'applystyle',);
            }

            // applycustomvectorstyle
            if ($pathinfo === '/apply/cstyle') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::applyCustomStyleAction',  '_route' => 'applycustomvectorstyle',);
            }

        }

        // deletestyle
        if ($pathinfo === '/deletestyle') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\StyleController::deleteStyleAction',  '_route' => 'deletestyle',);
        }

        // getpalettelist
        if ($pathinfo === '/list/palettes') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::listPalettesAction',  '_route' => 'getpalettelist',);
        }

        if (0 === strpos($pathinfo, '/palette')) {
            if (0 === strpos($pathinfo, '/palettes')) {
                // showpalettelist
                if ($pathinfo === '/palettes/list') {
                    return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::listPalettesEditorAction',  '_route' => 'showpalettelist',);
                }

                // showpalettelisteditor
                if ($pathinfo === '/palettes/editorlist') {
                    return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::listPalettesMainEditorAction',  '_route' => 'showpalettelisteditor',);
                }

            }

            // getpalette
            if (0 === strpos($pathinfo, '/palette/get') && preg_match('#^/palette/get/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getpalette')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::getPaletteAction',));
            }

            // getpalettecompressed
            if (0 === strpos($pathinfo, '/palette/cget') && preg_match('#^/palette/cget/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getpalettecompressed')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::getPaletteCompressedAction',));
            }

            // savepalette
            if (0 === strpos($pathinfo, '/palette/save') && preg_match('#^/palette/save(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_savepalette;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'savepalette')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::savePaletteAction',  'id' => NULL,));
            }
            not_savepalette:

            // showpalette
            if (preg_match('#^/palette/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'showpalette')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::showPaletteAction',));
            }

            // paletteeditor
            if (0 === strpos($pathinfo, '/paletteeditor') && preg_match('#^/paletteeditor(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'paletteeditor')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::paletteEditorAction',  'id' => NULL,));
            }

        }

        if (0 === strpos($pathinfo, '/delete')) {
            // deletepaletteconfirm
            if (0 === strpos($pathinfo, '/deleteconfirm/palette') && preg_match('#^/deleteconfirm/palette/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletepaletteconfirm')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::deletePaletteConfirmAction',));
            }

            if (0 === strpos($pathinfo, '/deletepalette')) {
                // deletepalette
                if (preg_match('#^/deletepalette/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletepalette')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::deletePaletteAction',));
                }

                // deletepalettesuccess
                if (0 === strpos($pathinfo, '/deletepalette/success') && preg_match('#^/deletepalette/success/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletepalettesuccess')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::deletePaletteSuccessAction',));
                }

            }

        }

        // updatepalettestyle
        if ($pathinfo === '/apply/palette') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_updatepalettestyle;
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\PaletteController::applyPaletteAction',  '_route' => 'updatepalettestyle',);
        }
        not_updatepalettestyle:

        // geoexpl
        if (0 === strpos($pathinfo, '/editor') && preg_match('#^/editor(?:/(?P<datasource>[^/]++)(?:/(?P<id>[^/]++))?)?$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'geoexpl')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\EditorController::showEditorAction',  'datasource' => NULL,  'id' => NULL,));
        }

        // getlayertype
        if (0 === strpos($pathinfo, '/gettype/layer') && preg_match('#^/gettype/layer/(?P<cs>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getlayertype')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\LayerController::getLayerTypeAction',));
        }

        // editorlogin
        if ($pathinfo === '/auth/editor') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_editorlogin;
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AuthManagerController::loginFromEditorAction',  '_route' => 'editorlogin',);
        }
        not_editorlogin:

        if (0 === strpos($pathinfo, '/favorites')) {
            // addtofavorites
            if ($pathinfo === '/favorites/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_addtofavorites;
                }

                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::addToFavoriteAction',  '_route' => 'addtofavorites',);
            }
            not_addtofavorites:

            // removefromfavorites
            if (0 === strpos($pathinfo, '/favorites/remove') && preg_match('#^/favorites/remove/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_removefromfavorites;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'removefromfavorites')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\CatalogController::removeFavoriteAction',));
            }
            not_removefromfavorites:

        }

        if (0 === strpos($pathinfo, '/admin')) {
            // adminhome
            if ($pathinfo === '/admin/home') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\DefaultController::adminAction',  '_route' => 'adminhome',);
            }

            // admingeoserver
            if ($pathinfo === '/admin/geoserver') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AdminController::geoserverPageAction',  '_route' => 'admingeoserver',);
            }

            // admingeoserverrestart
            if ($pathinfo === '/admin/restart/geoserver') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AdminController::geoserverRestartAction',  '_route' => 'admingeoserverrestart',);
            }

            // adminnewslist
            if ($pathinfo === '/admin/list/news') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AdminController::newsListAction',  '_route' => 'adminnewslist',);
            }

            // admingetnews
            if ($pathinfo === '/admin/get/news') {
                return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AdminController::getNewsListAction',  '_route' => 'admingetnews',);
            }

            // admineditnews
            if (0 === strpos($pathinfo, '/admin/edit/news') && preg_match('#^/admin/edit/news(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admineditnews')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AdminController::editNewsAction',  'id' => NULL,));
            }

            // adminsavenews
            if (0 === strpos($pathinfo, '/admin/save/news') && preg_match('#^/admin/save/news(?:/(?P<id>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'adminsavenews')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AdminController::saveNewsAction',  'id' => NULL,));
            }

            // admindeletenews
            if (0 === strpos($pathinfo, '/admin/delete/news') && preg_match('#^/admin/delete/news/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admindeletenews')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\AdminController::deleteNewsAction',));
            }

        }

        // migrateSystem
        if ($pathinfo === '/system/restore') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\MigrateController::RestoreOGISAction',  '_route' => 'migrateSystem',);
        }

        // createMany
        if (0 === strpos($pathinfo, '/createentity') && preg_match('#^/createentity/(?P<type>[^/]++)/(?P<number>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'createMany')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\SetupController::createRolesAction',));
        }

        // showuserrole
        if (0 === strpos($pathinfo, '/userrole') && preg_match('#^/userrole/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'showuserrole')), array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\UserController::showUserRoleAction',));
        }

        // rasteropeations
        if ($pathinfo === '/rasterop') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_rasteropeations;
            }

            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\RasterOperationsController::rasterOperationAction',  '_route' => 'rasteropeations',);
        }
        not_rasteropeations:

        // testrasteralgebra
        if ($pathinfo === '/test/algebra') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\RasterOperationsController::testRasterAlgeraAction',  '_route' => 'testrasteralgebra',);
        }

        // testalgebra
        if ($pathinfo === '/operation/algebra') {
            return array (  '_controller' => 'OGIS\\IndexBundle\\Controller\\RasterOperationsController::testAlgebraAction',  '_route' => 'testalgebra',);
        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                    goto not_fos_user_profile_edit;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }
            not_fos_user_profile_edit:

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/register') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_registration_register;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }
                not_fos_user_registration_register:

                if (0 === strpos($pathinfo, '/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ($pathinfo === '/resetting/send-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ($pathinfo === '/resetting/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        // fos_user_change_password
        if ($pathinfo === '/profile/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_security_login;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }
                not_fos_user_security_login:

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_security_logout;
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }
            not_fos_user_security_logout:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
