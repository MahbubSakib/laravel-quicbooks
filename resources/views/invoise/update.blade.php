<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



<div class="row">
    <div class="col-md-12">
        <form method="post" action="{{ route('update', $invoice->Id) }}">
        {{ csrf_field() }}
            <div class="panel panel-flat">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="custom_form_group form-group">
                                    <label class="col-lg-12 control-label">Id:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control-2 text_capital" name="Id" value="{{$invoice->Id}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="custom_form_group form-group">
                                    <label class="col-lg-12 control-label">Detail Type:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control-2 text_capital" name="DetailType" value="{{$invoice->Line[0]->DetailType}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="custom_form_group form-group">
                                    <label class="col-lg-12 control-label">Amount:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control-2 text_capital" name="Amount" value="{{$invoice->Line[0]->Amount}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="custom_form_group form-group">
                                    <label class="col-lg-12 control-label">Item Ref:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control-2 text_capital" name="value" value="{{$invoice->Line[0]->SalesItemLineDetail->ItemRef}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="row">
                                <div class="custom_form_group form-group">
                                    <label class="col-lg-12 control-label">Customer Ref:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control-2 text_capital" name="value2" value="{{$invoice->CustomerRef}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <button type="submit">Update</button>
        </form>
    </div>
</div>

