<form action="admin/vehicle" method="POST" class="needs-validation modal-content" enctype="multipart/form-data"
    onsubmit="submitFormAxios(event)">
    @crsf
    <div class="card-header my-3 p-2 border-bottom">
        <h4>Add Driver Performance</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="model" class="col-sm-5 col-form-label">Driver Name <i
                            class="text-danger">*</i></label> </label>
                    <div class="col-sm-7">
                        <input name="name" class="form-control" type="text" placeholder="Vehicle Model"
                            id="name" value="" required>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="overTimeStatus" class="col-sm-5 col-form-label">Over time status <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="overTimeStatus" id="overTimeStatusYes"
                                value="yes" required>
                            <label class="form-check-label" for="overTimeStatusYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="overTimeStatus" id="overTimeStatusNo"
                                value="no" required>
                            <label class="form-check-label" for="overTimeStatusNo">No</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row my-2">
                    <label for="salaryStatus" class="col-sm-5 col-form-label">Salary Status <i
                            class="text-danger">*</i></label>
                    <div class="col-sm-7">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="salaryStatus" id="salaryStatusYes"
                                value="yes" required>
                            <label class="form-check-label" for="salaryStatusYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="salaryStatus" id="salaryStatusNo"
                                value="no" required>
                            <label class="form-check-label" for="salaryStatusNo">No</label>
                        </div>
                    </div>
                </div>


                <div class="form-group row my-2">
                    <label for="overtimePayment" class="col-sm-5 col-form-label">Over Time Payment<i
                            class="text-danger">*</i></label> </label>
                    <div class="col-sm-7">
                        <input name="overtimePayment" class="form-control" type="text" placeholder="Enter Over Time "
                            id="plate_number" value="" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">

                <div class="form-group row my-2">
                    <label for="performanceBonus" class="col-sm-5 col-form-label">Performance bonus<i
                            class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="performanceBonus" class="form-control" type="text"
                            placeholder="Enter performance Bonus" id="performanceBonus" value="" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="penalty Reason" class="col-sm-5 col-form-label">Penalty Reason<i
                            class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="penaltyReason" class="form-control" type="text"
                            placeholder="Enter penalty reason" id="penaltyReason" value="" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="penaltyAmount" class="col-sm-5 col-form-label">Penalty Amount<i
                            class="text-danger">*</i> </label>
                    <div class="col-sm-7">
                        <input name="penaltyAmount" class="form-control" type="number"
                            placeholder="Enter penalty amount" id="penaltyAmount" value="" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="penaltyDate" class="col-sm-5 col-form-label">Penalty Date<i class="text-danger">*</i>
                    </label>
                    <div class="col-sm-7">
                        <input name="penaltyDate" class="form-control" type="date"
                            placeholder="Enter penalty date" id="penaltyDate" value="" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" type="submit">Save</button>
    </div>
</form>
