<div class="row mt-4 form-data-default">
    <div class="col-5 col-xl-2">
        <label class="mb-2">Ca<span class="text-danger">*</span></label>
        <select class="form-select" name="information_day_1[]" required>
            <option class="application__selectOption--disabled" value="" disabled="disabled"
                selected="selected">Chọn ca</option>
            <option value="Ca sáng">Ca sáng</option>
            <option value="Ca chiều">Ca chiều</option>
        </select>
    </div>
    <div class="col-5 col-xl-3 px-0">
        <label class="mb-2">Từ ngày<span class="text-danger">*</span></label>
        <?php
        date_default_timezone_set('Asia/Kolkata');
        ?>
        <input class="form-control" type="date" name="information_day_2[]" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="col-5 col-xl-2 mt-3 mt-xl-0">
        <label class="mb-2">Ca<span class="text-danger">*</span></label>
        <select class="form-select" name="information_day_3[]" required>
            <option class="application__selectOption--disabled" value="" disabled="disabled"
                selected="selected">Chọn ca</option>
            <option value="Ca sáng">Ca sáng</option>
            <option value="Ca chiều">Ca chiều</option>
        </select>
    </div>
    <div class="col-5 col-xl-3 mt-3 mt-xl-0 px-0">
        <label class="mb-2">Đến ngày<span class="text-danger">*</span></label>
        <input class="form-control" type="date" name="information_day_4[]" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <i class="fas fa-times delete__data--button mt-0 mt-xl-4" style="width:35px; height:40px;"></i>
</div>


