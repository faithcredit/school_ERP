@extends('layouts.master')
@section('page_title', 'Admit Student')
@section('content')
        <div class="card">
            <div class="card-header bg-white header-elements-inline">
                <h6 class="card-title">Please fill The form Below To Admit A New Student</h6>

                {!! Qs::getPanelOptions() !!}
            </div>

            <form id="ajax-reg" method="post" enctype="multipart/form-data" action="{{ route('students.store') }}" class='p-3' data-fouc>
               @csrf
                <h6><b>Personal data</b></h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name: <span class="text-danger">*</span></label>
                                <input value="{{ old('name') }}" required type="text" name="name" placeholder="Full Name" class="form-control">
                                </div>
                            </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address: <span class="text-danger">*</span></label>
                                <input value="{{ old('address') }}" class="form-control" placeholder="Address" name="address" type="text" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email address: </label>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email Address">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="gender">Gender: <span class="text-danger">*</span></label>
                                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                                    <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone:</label>
                                <input value="{{ old('phone') }}" type="text" name="phone" class="form-control" placeholder="" >
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telephone:</label>
                                <input value="{{ old('phone2') }}" type="text" name="phone2" class="form-control" placeholder="" >
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Date of Birth:</label>
                                <input name="dob" value="{{ old('dob') }}" type="text" class="form-control date-pick" placeholder="Select Date...">

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nal_id">Nationality: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="nal_id" id="nal_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($nationals as $nal)
                                        <option {{ (old('nal_id') == $nal->id ? 'selected' : '') }} value="{{ $nal->id }}">{{ $nal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="state_id">State: <span class="text-danger">*</span></label>
                            <select onchange="getLGA(this.value)" required data-placeholder="Choose.." class="select-search form-control" name="state_id" id="state_id">
                                <option value=""></option>
                                @foreach($states as $st)
                                    <option {{ (old('state_id') == $st->id ? 'selected' : '') }} value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="lga_id">City: <span class="text-danger">*</span></label>
                            <select required data-placeholder="Select State First" class="select-search form-control" name="lga_id" id="lga_id">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bg_id">Blood Group: </label>
                                <select class="select form-control" id="bg_id" name="bg_id" data-fouc data-placeholder="Choose..">
                                    <option value=""></option>
                                    @foreach(App\Models\BloodGroup::all() as $bg)
                                        <option {{ (old('bg_id') == $bg->id ? 'selected' : '') }} value="{{ $bg->id }}">{{ $bg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="d-block">Upload Passport Photo:</label>
                                <input value="{{ old('photo') }}" accept="image/*" type="file" name="photo" class="form-input-styled" data-fouc>
                                <span class="form-text text-muted">Accepted Images: jpeg, png. Max file size 2Mb</span>
                            </div>
                        </div>
                    </div>

                </fieldset>

                <h6><b>Student Data</b></h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_class_id">Class: <span class="text-danger">*</span></label>
                                <select onchange="getClassSections(this.value)" data-placeholder="Choose..." required name="my_class_id" id="my_class_id" class="select-search form-control">
                                    <option value=""></option>
                                    @foreach($my_classes as $c)
                                        <option {{ (old('my_class_id') == $c->id ? 'selected' : '') }} value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                </select>
                        </div>
                            </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="section_id">Section: <span class="text-danger">*</span></label>
                                <select data-placeholder="Select Class First" required name="section_id" id="section_id" class="select-search form-control">
                                    <option {{ (old('section_id')) ? 'selected' : '' }} value="{{ old('section_id') }}">{{ (old('section_id')) ? 'Selected' : '' }}</option>
                                </select>
                            </div>
                        </div>

                      <div class="col-md-1">
                            <div class="form-group">
                                <label for="section_id">Roll: <span class="text-danger">*</span></label>
                                 <input value="{{ old('roll_num') }}" type="text" name="roll_num" class="form-control" placeholder="" >
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_parent_id">Parent/Guardian (*If already exist): </label>
                                <select data-placeholder="Choose..."  name="my_parent_id" id="my_parent_id" class="select-search form-control">
                                    <option  value=""></option>
                                    @foreach($parents as $p)
                                        <option {{ (old('my_parent_id') == $p->id) ? 'selected' : '' }} value="{{$p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year_admitted">Year Admitted: <span class="text-danger">*</span></label>
                                <select data-placeholder="Choose..." required name="year_admitted" id="year_admitted" class="select-search form-control">
                                    <option value=""></option>
                                    @for($y=date('Y', strtotime('- 10 years')); $y<=date('Y'); $y++)
                                        <option {{ (old('year_admitted') == $y) ? 'selected' : '' }} value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="my_parent_id">Parent/Guardian (*New): </label>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#parentform">
                                Add Parent Name
                            </button> 
                           
                        </div>
                    </div>

                    <div class="col-md-3">
                        <h5><input type="hidden" name="my_pid" id="my_pid" /><span id="parentName"></span></h5>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="dorm_id">Dormitory: </label>
                            <select data-placeholder="Choose..."  name="dorm_id" id="dorm_id" class="select-search form-control">
                                <option value=""></option>
                                @foreach($dorms as $d)
                                    <option {{ (old('dorm_id') == $d->id) ? 'selected' : '' }} value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                            </select>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dormitory Room No:</label>
                                <input type="text" name="dorm_room_no" placeholder="Dormitory Room No" class="form-control" value="{{ old('dorm_room_no') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sport House:</label>
                                <input type="text" name="house" placeholder="Sport House" class="form-control" value="{{ old('house') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Admission Number:</label>
                                <input type="text" name="adm_no" placeholder="Admission Number" class="form-control" value="{{ old('adm_no') }}">
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div style='text-align:right'>
                    <a href="#finish" class="btn btn-primary" role="menuitem">Submit form <i class="icon-arrow-right14 ml-2"></i></a>
                </div>
            </form>
        </div>


        <!-- Parent Form -->

        <div class="modal fade" id="parentform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="exampleModalLabel">Add Parent Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="parent-ajax-reg" method="post" enctype="multipart/form-data" action="{{ route('students.parent') }}">
      @csrf
        <div class="modal-body">
            <input type="hidden" name="user_type" value="parent">
        <div class="form-group">
            <label for="parent_name">Parent/Guardian Name</label>
            <input value="{{ old('name') }}" type="text" name="name" placeholder="Full Name" class="form-control">
        </div>

        <div class="form-group">
            <label for="parent_name">Address</label>
            <input value="{{ old('address') }}" placeholder="Address" name="address" type="text" class="form-control">
        </div>

 


            <div class="form-group">
                <label for="gender">Gender: <span class="text-danger">*</span></label>
                <select class="select form-control" id="gender" name="gender" required data-fouc data-placeholder="Choose..">
                    <option value=""></option>
                    <option {{ (old('gender') == 'Male') ? 'selected' : '' }} value="Male">Male</option>
                    <option {{ (old('gender') == 'Female') ? 'selected' : '' }} value="Female">Female</option>
                </select>
            </div>


     <div class="form-group">
                <label for="parent_name">Mother's Name</label>
                <input value="{{ old('mother_name') }}" type="text" name="mother_name" placeholder="Full Name" class="form-control">
            </div>

   
            <div class="form-group">
            <label for="lga_id">City: <span class="text-danger">*</span></label>
            <select  class="form-control" name="parent_lga_id" id="lga_id">
                @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name}}</option>
                @endforeach
            </select>
            </div>
        
        </div>
        <div class="modal-footer border-top-0 d-flex justify-content-center">
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

        <!-- Parent Form end -->
@endsection
@section('scripts')
<script src="{{ asset('assets/js/pages/super_team/students/add.js') }}"></script>
@endsection