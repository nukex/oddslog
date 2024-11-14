<div class="popover p-3"></div>

<script id="stat-popover" type="template">
    <div class="mb-2">
        <div class="d-flex flex-wrap justify-content-center">
            <div class="small">##title##</div>
        </div>
        <div class="progress progress-sm">

            <div class="progress-bar bg-primary" role="progressbar" style="width: ##percent0##%" data-bs-toggle="tooltip" title="##percent0##">##val0##</div>

            <div class="progress-bar " role="progressbar" style="width: 1%;"></div>

            <div class="progress-bar bg-success " role="progressbar" style="width: ##percent1##%" data-bs-toggle="tooltip" title="##percent1##">##val1##</div>
        </div>
    </div>
</script>

<div class="splash"></div>



<div class="toast-container position-fixed top-0 end-0 p-3" id="toast" style="z-index: 1100">

    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="1000">

        <div class="toast-header">
            <i class="icon me-2"></i> <strong class="me-auto fs-5 text-capitalize"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>

        <div class="toast-body fs-6">
        </div>
    </div>
</div>



<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="flex-row-reverse">
        </ul>
    </div>
</div>

<div class="back-to-top bg-800 opacity-50">
    <a id="back-to-top" href="#" class="btn btn-lg " role="button">🔝</a>
 
</div>


<!-- Modal -->
<div class="modal fade blur-7" id="MainModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
    <div class="modal-dialog ">

        <div class="modal-content">

            <div class="modal-header bg-900">
                <h5 class="modal-title text-capitalize" id="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">
            </div>

   
        </div>
    </div>
</div>

<!-- Search -->

