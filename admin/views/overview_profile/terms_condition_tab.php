<div class="tab-pane fade show" id="t_c" role="tabpanel">
    <div class="card rounded-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="input-block mb-3">
                        <label class="col-form-label">Terms And Conditions</label>
                        <input class="form-control" type="file" name="fileTerms" id="terms_condition" <?php if($row['terms_condition']){echo 'disabled';} ?>>
                    </div>
                    <input type="hidden" id="img_pathTerms" value="<?php if($row['terms_condition']){echo $row['terms_condition'];} ?>">
                    <?php if($row['terms_condition']){ ?>
                        <div id="previewTerms">
                            <div id="image_previewTerms">
                                <img alt="Preview" class="imgSize" id="img_preTerms" width="150px" height="150px" src="../../../uploading/<?php echo $row['terms_condition']; ?>">
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div id="previewTerms" style = "display:none;">
                            <div id="image_previewTerms">
                                <img alt="Preview" class="imgSize" id="img_preTerms" width="150px" height="150px">
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="d-flex justify-content-center mb-4">
                        <button type="submit" class="btn btn-primary px-5 py-2" id="terms_condition_submit" <?php if($row['terms_condition']){echo 'disabled';} ?>>Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>