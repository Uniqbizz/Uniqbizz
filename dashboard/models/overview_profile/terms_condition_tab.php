<div class="tab-pane fade show" id="t_c" role="tabpanel">
    <div class="card rounded-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="input-block mb-3">
                        <label class="col-form-label">Terms And Conditions</label>
                    </div>
                    <div id="previewTerms">
                        <div id="image_previewTerms">
                            <img 
                                alt="Preview" 
                                class="imgSize" 
                                id="img_preTerms" 
                                width="150" 
                                height="150"
                                src="../../uploading/<?= !empty($terms_condition) ? htmlspecialchars($terms_condition) : 'default.png' ?>"
                                onerror="this.src='../../uploading/not_uploaded.png';"
                            >
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>