<!DOCTYPE html>
<!--
Copyright 2012 Mozilla Foundation

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->
<html dir="ltr" mozdisallowselectionprint moznomarginboxes>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--#if GENERIC || CHROME-->
    <meta name="google" content="notranslate">
<!--#endif-->
    <title>PDF.js viewer</title>

<!--#if FIREFOX || MOZCENTRAL-->
<!--#include viewer-snippet-firefox-extension.html-->
<!--#endif-->

    <link rel="stylesheet" href="viewer.css"/>
<!--#if !PRODUCTION-->
   <!-- <link rel="resource" type="application/l10n" href="locale/locale.properties"/> -->
<!--#endif-->

<!--#if !(FIREFOX || MOZCENTRAL || CHROME)-->
    <script type="text/javascript" src="js/compatibility.js"></script>
<!--#endif-->

<!--#if !PRODUCTION-->
    <script type="text/javascript" src="js/l10n.js"></script>
<!--#endif-->

<!--#if !PRODUCTION-->
    <script type="text/javascript" src="js/util.js"></script>
    <script type="text/javascript" src="js/colorspace.js"></script>
    <script type="text/javascript" src="js/pattern.js"></script>
    <script type="text/javascript" src="js/function.js"></script>
    <script type="text/javascript" src="js/annotation.js"></script>
    <script type="text/javascript" src="js/api.js"></script>
    <script type="text/javascript" src="js/canvas.js"></script> 
    <script type="text/javascript" src="js/font_loader.js"></script>
    <script type="text/javascript">PDFJS.workerSrc = 'js/worker_loader.js';</script>
<!--#endif-->

<!--#if GENERIC || CHROME-->
<!--#include viewer-snippet.html-->
<!--#endif-->

<!--#if !PRODUCTION-->
    <script type="text/javascript" src="js/ui_utils.js"></script>
    <script type="text/javascript" src="js/download_manager.js"></script>
    <script type="text/javascript" src="js/settings.js"></script>
    <script type="text/javascript" src="js/page_view.js"></script>
    <script type="text/javascript" src="js/thumbnail_view.js"></script>
    <script type="text/javascript" src="js/text_layer_builder.js"></script>
    <script type="text/javascript" src="js/pdf_find_controller.js"></script>
    <script type="text/javascript" src="js/pdf_history.js"></script>
    <script type="text/javascript" src="js/secondary_toolbar.js"></script>
    <script type="text/javascript" src="js/presentation_mode.js"></script>
<!--#endif-->

    <script type="text/javascript" src="js/debugger.js"></script>

  </head>

  <body tabindex="1">
    <div id="outerContainer" class="loadingInProgress">

      <div id="sidebarContainer">
        <div id="toolbarSidebar">
          <div class="splitToolbarButton toggled">
            <button id="viewThumbnail" class="toolbarButton group toggled" title="Show Thumbnails" tabindex="2" data-l10n-id="thumbs">
               <span data-l10n-id="thumbs_label">Thumbnails</span>
            </button>
            <button id="viewOutline" class="toolbarButton group" title="Show Document Outline" tabindex="3" data-l10n-id="outline">
               <span data-l10n-id="outline_label">Document Outline</span>
            </button>
          </div>
        </div>
        <div id="sidebarContent">
          <div id="thumbnailView">
          </div>
          <div id="outlineView" class="hidden">
          </div>
        </div>
      </div>  <!-- sidebarContainer -->

      <div id="mainContainer">
        <div class="findbar hidden doorHanger hiddenSmallView" id="findbar">
          <label for="findInput" class="toolbarLabel" data-l10n-id="find_label">Find:</label>
          <input id="findInput" class="toolbarField" tabindex="41">
          <div class="splitToolbarButton">
            <button class="toolbarButton findPrevious" title="" id="findPrevious" tabindex="42" data-l10n-id="find_previous">
              <span data-l10n-id="find_previous_label">Previous</span>
            </button>
            <div class="splitToolbarButtonSeparator"></div>
            <button class="toolbarButton findNext" title="" id="findNext" tabindex="43" data-l10n-id="find_next">
              <span data-l10n-id="find_next_label">Next</span>
            </button>
          </div>
          <input type="checkbox" id="findHighlightAll" class="toolbarField">
          <label for="findHighlightAll" class="toolbarLabel" tabindex="44" data-l10n-id="find_highlight">Highlight all</label>
          <input type="checkbox" id="findMatchCase" class="toolbarField">
          <label for="findMatchCase" class="toolbarLabel" tabindex="45" data-l10n-id="find_match_case_label">Match case</label>
          <span id="findMsg" class="toolbarLabel"></span>
        </div>  <!-- findbar -->

        <div id="secondaryToolbar" class="secondaryToolbar hidden doorHangerRight">
          <div id="secondaryToolbarButtonContainer">
            <button id="secondaryPresentationMode" class="secondaryToolbarButton presentationMode visibleLargeView" title="Switch to Presentation Mode" tabindex="18" data-l10n-id="presentation_mode">
              <span data-l10n-id="presentation_mode_label">Presentation Mode</span>
            </button>

            <button style="display:none;" id="secondaryOpenFile" class="secondaryToolbarButton openFile visibleLargeView" title="Open File" tabindex="19" data-l10n-id="open_file">
              <span data-l10n-id="open_file_label">Open</span>
            </button>

            <button id="secondaryPrint" class="secondaryToolbarButton print visibleMediumView" title="Print" tabindex="20" data-l10n-id="print">
              <span data-l10n-id="print_label">Print</span>
            </button>

            <button id="secondaryDownload" class="secondaryToolbarButton download visibleMediumView" title="Download" tabindex="21" data-l10n-id="download">
              <span data-l10n-id="download_label">Download</span>
            </button>

            <a href="#" id="secondaryViewBookmark" class="secondaryToolbarButton bookmark visibleSmallView" title="Current view (copy or open in new window)" tabindex="22" data-l10n-id="bookmark">
              <span data-l10n-id="bookmark_label">Current View</span>
            </a>

            <div class="horizontalToolbarSeparator visibleLargeView"></div>

            <button id="firstPage" class="secondaryToolbarButton firstPage" title="Go to First Page" tabindex="23" data-l10n-id="first_page">
              <span data-l10n-id="first_page_label">Go to First Page</span>
            </button>
            <button id="lastPage" class="secondaryToolbarButton lastPage" title="Go to Last Page" tabindex="24" data-l10n-id="last_page">
              <span data-l10n-id="last_page_label">Go to Last Page</span>
            </button>

            <div class="horizontalToolbarSeparator"></div>

            <button id="pageRotateCw" class="secondaryToolbarButton rotateCw" title="Rotate Clockwise" tabindex="25" data-l10n-id="page_rotate_cw">
              <span data-l10n-id="page_rotate_cw_label">Rotate Clockwise</span>
            </button>
            <button id="pageRotateCcw" class="secondaryToolbarButton rotateCcw" title="Rotate Counterclockwise" tabindex="26" data-l10n-id="page_rotate_ccw">
              <span data-l10n-id="page_rotate_ccw_label">Rotate Counterclockwise</span>
            </button>
          </div>
        </div>  <!-- secondaryToolbar -->

        <div class="toolbar">
          <div id="toolbarContainer">
            <div id="toolbarViewer">
              <div id="toolbarViewerLeft">
                <!-- <button id="sidebarToggle" class="toolbarButton" title="Toggle Sidebar" tabindex="4" data-l10n-id="toggle_sidebar">
                  <span data-l10n-id="toggle_sidebar_label">Toggle Sidebar</span>
                </button> -->
                <div class="toolbarButtonSpacer"></div>
               <!-- <button id="viewFind" class="toolbarButton group hiddenSmallView" title="Find in Document" tabindex="5" data-l10n-id="findbar">
                   <span data-l10n-id="findbar_label">Find</span>
                </button> -->
                <div class="splitToolbarButton">
                  <button class="toolbarButton pageUp" title="Previous Page" id="previous" tabindex="6" data-l10n-id="previous">
                    <span data-l10n-id="previous_label">Previous</span>
                  </button>
                  <div class="splitToolbarButtonSeparator"></div>
                  <button class="toolbarButton pageDown" title="Next Page" id="next" tabindex="7" data-l10n-id="next">
                    <span data-l10n-id="next_label">Next</span>
                  </button>
                </div>
                <label id="pageNumberLabel" class="toolbarLabel" for="pageNumber" data-l10n-id="page_label">Page: </label>
                <input type="number" id="pageNumber" class="toolbarField pageNumber" value="1" size="4" min="1" tabindex="8">
                </input>
                <span id="numPages" class="toolbarLabel"></span>
              </div>
              <div id="toolbarViewerRight">
                <button id="presentationMode" class="toolbarButton presentationMode hiddenLargeView" title="Switch to Presentation Mode" tabindex="12" data-l10n-id="presentation_mode">
                  <span data-l10n-id="presentation_mode_label">Presentation Mode</span>
                </button>

                <button id="openFile" class="toolbarButton openFile hiddenLargeView" title="Open File" tabindex="13" data-l10n-id="open_file">
                  <span data-l10n-id="open_file_label">Open</span>
                </button>

                <button id="print" class="toolbarButton print hiddenMediumView" title="Print" tabindex="14" data-l10n-id="print">
                  <span data-l10n-id="print_label">Print</span>
                </button>

                <button id="download" class="toolbarButton download hiddenMediumView" title="Download" tabindex="15" data-l10n-id="download">
                  <span data-l10n-id="download_label">Download</span>
                </button>
                <!-- <div class="toolbarButtonSpacer"></div> -->
                <a href="#" id="viewBookmark" class="toolbarButton bookmark hiddenSmallView" title="Current view (copy or open in new window)" tabindex="16" data-l10n-id="bookmark">
                  <span data-l10n-id="bookmark_label">Current View</span>
                </a>

                <div class="verticalToolbarSeparator hiddenSmallView"></div>
                
                <button id="secondaryToolbarToggle" class="toolbarButton" title="Tools" tabindex="17" data-l10n-id="tools">
                  <span data-l10n-id="tools_label">Tools</span>
                </button> 
              </div>
              <div class="outerCenter">
                <div class="innerCenter" id="toolbarViewerMiddle">
                  <div class="splitToolbarButton">
                    <button id="zoomOut" class="toolbarButton zoomOut" title="Zoom Out" tabindex="9" data-l10n-id="zoom_out">
                      <span data-l10n-id="zoom_out_label">Zoom Out</span>
                    </button>
                    <div class="splitToolbarButtonSeparator"></div>
                    <button id="zoomIn" class="toolbarButton zoomIn" title="Zoom In" tabindex="10" data-l10n-id="zoom_in">
                      <span data-l10n-id="zoom_in_label">Zoom In</span>
                     </button>
                  </div>
                  <span id="scaleSelectContainer" class="dropdownToolbarButton">
                     <select id="scaleSelect" title="Zoom" tabindex="11" data-l10n-id="zoom">
                      <option id="pageAutoOption" value="auto" selected="selected" data-l10n-id="page_scale_auto">Automatic Zoom</option>
                      <option id="pageActualOption" value="page-actual" data-l10n-id="page_scale_actual">Actual Size</option>
                      <option id="pageFitOption" value="page-fit" data-l10n-id="page_scale_fit">Fit Page</option>
                      <option id="pageWidthOption" value="page-width" data-l10n-id="page_scale_width">Full Width</option>
                      <option id="customScaleOption" value="custom"></option>
                      <option value="0.5">50%</option>
                      <option value="0.75">75%</option>
                      <option value="1">100%</option>
                      <option value="1.25">125%</option>
                      <option value="1.5">150%</option>
                      <option value="2">200%</option>
                    </select>
                  </span>
                </div>
              </div>
            </div>
            <div id="loadingBar">
              <div class="progress">
                <div class="glimmer">
                </div>
              </div>
            </div>
          </div>
        </div>

        <menu type="context" id="viewerContextMenu">
          <menuitem id="contextFirstPage" label="First Page"
                    data-l10n-id="first_page"></menuitem>
          <menuitem id="contextLastPage" label="Last Page"
                    data-l10n-id="last_page"></menuitem>
          <menuitem id="contextPageRotateCw" label="Rotate Clockwise"
                    data-l10n-id="page_rotate_cw"></menuitem>
          <menuitem id="contextPageRotateCcw" label="Rotate Counter-Clockwise"
                    data-l10n-id="page_rotate_ccw"></menuitem>
        </menu>

<!--#if (FIREFOX || MOZCENTRAL) -->
<!--    <div id="viewerContainer"> -->
<!--#else -->
        <div id="viewerContainer" tabindex="0">
<!--#endif -->
          <div id="viewer"></div>
        </div>

        <div id="errorWrapper" hidden='true'>
          <div id="errorMessageLeft">
            <span id="errorMessage"></span>
            <button id="errorShowMore" data-l10n-id="error_more_info">
              More Information
            </button>
            <button id="errorShowLess" data-l10n-id="error_less_info" hidden='true'>
              Less Information
            </button>
          </div>
          <div id="errorMessageRight">
            <button id="errorClose" data-l10n-id="error_close">
              Close
            </button>
          </div>
          <div class="clearBoth"></div>
          <textarea id="errorMoreInfo" hidden='true' readonly="readonly"></textarea>
        </div>
      </div> <!-- mainContainer -->
<!--
      <div id="overlayContainer" class="hidden">
        <div id="promptContainer">
          <div id="passwordContainer" class="prompt doorHanger">
            <div class="row">
              <p id="passwordText" data-l10n-id="password_label">Enter the password to open this PDF file:</p>
            </div>
            <div class="row">
              <input type="password" id="password" class="toolbarField" />
            </div>
            <div class="row">
              <button id="passwordCancel" class="promptButton"><span data-l10n-id="password_cancel">Cancel</span></button>
              <button id="passwordSubmit" class="promptButton"><span data-l10n-id="password_ok">OK</span></button>
            </div>
          </div>
        </div>
      </div> -->

    </div> <!-- outerContainer -->
    <div id="printContainer"></div>
<!--#if !(FIREFOX || MOZCENTRAL)-->
<!--#include viewer-snippet-mozPrintCallback-polyfill.html-->
<!--#endif--->
<input type="hidden" value="<?php echo base64_decode($_GET['query']); ?>" id="pdffile">
<script type="text/javascript" src="js/viewer.js"></script>
  </body>
</html>
