<div class="tab-pane fade show active" id="list-dash" role="tabpanel" aria-labelledby="list-dash-list">
    <div class="container-fluid container-fullw bg-white">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                            <i class="fa fa-list fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="StepTitle" style="margin-top: 5%;"> View Plants</h4>
                        <script>
                            function clickDiv(id) {
                                document.querySelector(id).click();
                            }
                        </script>
                        <p class="links cl-effect-1">
                            <a href="#list-plant" onclick="clickDiv('#list-plant-list')">
                                Plant List
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" style="left: -3%">
                <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                            <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="StepTitle" style="margin-top: 5%;"> View Medicines</h4>
                        <p class="links cl-effect-1">
                            <a href="#list-med" onclick="clickDiv('#list-med-list')">
                                Medicines List
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-white no-radius text-center">
                    <div class="panel-body">
                        <span class="fa-stack fa-2x">
                            <i class="fa fa-square fa-stack-2x text-primary"></i>
                            <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="StepTitle" style="margin-top: 5%;"> View Methods</h4>
                        <p class="links cl-effect-1">
                            <a href="#list-method" onclick="clickDiv('#list-method-list')">
                                Methods List
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Button Section -->
        <div class="col-sm-12 text-center" style="margin-top: 20px;">
            <button type="button" class="btn btn-success">Payment</button>
        </div>
    </div>
</div>
