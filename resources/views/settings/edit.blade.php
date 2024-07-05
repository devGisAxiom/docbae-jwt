@include('templates.header')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Add Settings
                    <small>Welcome to Docbae</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item">Docbae</li>
                    <li class="breadcrumb-item active">Add Settings</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>

                    <form action="{{ route('settings.update', ['id' => $settings->id]) }}" method="post">
                        @csrf
                        <div class="body">
                            <p style="font-size: 18px; font-weight:800">General Fee Structure</p>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Consultation Fee</label>
                                        <input type="number" name="consultation_fee" class="form-control"
                                            placeholder="Consultation Fee" value="{{ $settings->consultation_fee }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Commission percentage</label>
                                        <input type="number" class="form-control" name="commission_percentage"
                                            placeholder="Commission percentage"
                                            value="{{ $settings->commission_percentage }}">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Payment Type</label>

                                        <select class="form-control show-tick" name="payment_type">
                                            <option value="1"
                                                @if ($settings->payment_type == 1) selected='selected' @endif>Weekly
                                            </option>
                                            <option value="2"
                                                @if ($settings->payment_type == 2) selected='selected' @endif>Monthly
                                            </option>

                                        </select>

                                    </div>
                                </div>
                                <br>
                            </div>

                            <p style="font-size: 18px; font-weight:800">General Followup Days</p>

                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>followup Days</label>
                                        <input type="number" name="followup_days" class="form-control"
                                            placeholder="followup days" value="{{ $settings->followup_days }}">
                                    </div>
                                </div>

                            </div>


                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-round">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
