<template>

<!-- Page Content -->
<div class="body mb-5 mt-5">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mb-3">FAQ
    </h1>

    <hr>

    <!-- code can be added to <a> tags to make cards collapsable -->
    <div id="accordion" role="tablist" aria-multiselectable="true">
        <div class="card mb-5 shadow-sm">
            <div class="card-header" role="tab" id="headingOne">
                <h5 class="mb-0">
                    <a>How can I find a case study?</a>
                </h5>
            </div>
            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-body">
                    Once you have logged-in with a valid upr email address you may search for and view case studies by using the search bar
                    located in the home page or navigation headers of the website. Once you are in the search results page of the website you will
                    have the option to further filter the results of the search by selecting from a variety of filter options. Any case studies matching
                    the selected filters and text will be shown in the search results, you may select any of these to view the corresponding case study.
                </div>
            </div>
        </div>
        <div class="card mb-5 shadow-sm">
            <div class="card-header" role="tab" id="headingTwo">
                <h5 class="mb-0">
                    <a>How do I create a case study?</a>
                </h5>
            </div>
            <div id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo">
                <div class="card-body">
                    To create and edit a case study you must have collaborator permissions, as well as be the owner of the case study or belong to a group
                    that manages that case study. To request collaborator permissions simply click on the "collaborate" option located on the header bar
                    on the top of the screen.

                    This will create a request that must be approved by site administrators in order to allow access to the editing features of the website.
                    Once you have been approved you may create or edit cases from the "Cases" and "Groups" pages accesible from the header navigation 
                    drop-down menu, as well as by clicking on the "Collaborate" option.
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header" role="tab" id="headingThree">
                <h5 class="mb-0">
                    <a>I requested collaborator permissions why am I still not able to create a case study?</a>
                </h5>
            </div>
            <div id="collapseThree" role="tabpanel" aria-labelledby="headingThree">
                <div class="card-body">
                    After requesting collaborator permissions it may take some time for the site administrators to approve your request.
                    If your request has been declined and you believe this to be a mistake, you may contact the site administrators directly
                    to ask for details. For more information on how to contact site administrators please visit the "About" section of the website
                    by clicking on the "About" option located in the header of this page.
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
    export default {

    }
</script>

<style lang="scss" scoped>

</style>
