 @extends('layouts.page')

@section('css')
<link href="/plugins/chosen_v1.8.7/chosen.min.css" rel="stylesheet" >
<link href="/assets/vendor/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" >
<style>
    #search-form input{background: #fff;width: 150px;text-align:center;}
    .input-daterange{border-left: solid 1px #ddd;border-top-left-radius: 8px;border-bottom-left-radius: 8px;}
    .it-candidate,.it-assessor{text-transform: none!important;}
    .it-description{padding: 5px 0;min-height: 70px;}
    .interview-page .interview-list .interview-head h3{
        height: 120px;
    }
</style>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-6">
        <form id="search-form">
            <div class="form-group">
                <label class="col-md-3 control-label text-center"><h5 style="font-weight:bold;">Date range</h5></label>
                <div class="col-md-6">
                    <div class="input-daterange input-group" data-plugin-datepicker="">
                        <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" class="form-control" name="startd" readonly="" value="{{LT2IT($searchDateRange[0])}}" style="cursor:initial">
                        <span class="input-group-addon">to</span>
                        <input type="text" class="form-control" name="endd" readonly="" value="{{LT2IT($searchDateRange[1])}}" style="cursor:initial">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-6 text-right">
        <button class="btn btn-primary create-trigger" data-toggle="modal" data-target=".interview-modal">
            Add New Interview
            <i class="fa fa-plus"></i>
        </button>
    </div>
</div>

@foreach  ($interviewList as $i=>$v)
<?php if($i%3==0){echo ($i?'</div>':'').'<div class="row">';}?>
<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="interview-list ">
        <div class="interview-head">
            <h3 class="text-center interview-{{$v->id}}">{{$v->name}}</h3>
            <div class="interview-thumbnail">
                <div class="interview-thumbnail-inner">
                    <img src="/{{$v->preview_image?$v->preview_image:'app/interview_image/no-image.png'}}">
                </div>
            </div>
        </div>
        <div class="inerview-body">
            <h5 class='it-candidate'>Candidate : <a href='/admin/candidate?search-select={{$v->id}}' title="{{$v->candidateListTxt}}">{{($v->cc.' candidate')}}</a>, Close on <span> {{strtotime($v->ctt)?date('d.m.Y', strtotime($v->ctt)):''}}</span></h5>
            <h5 class='it-assessor' ass='{{$v->ass}}'>Assessor : <a href='/admin/assessor?search-select={{$v->id}}' title="{{$v->assessorListTxt}}">{{($v->ac.' assessor')}}</a>, Close on <span>{{strtotime($v->att)?date('d.m.Y', strtotime($v->att)):''}}</span></h5>
            <p class="it-description">{{$v->description}}</p>
            <div class="text-center">
                <button class="btn btn-warning update-trigger btn-sm" _iid="{{$v->id}}"  data-toggle="modal" data-target=".interview-modal" title="Edit name of the Interview, assessor, description">Edit</button>
                <a class="btn btn-success btn-sm" href="/admin/quiz?it={{$v->id}}" title="Edit Questions,time duration etc">Question</a>
                <button class="btn btn-danger delete-trigger btn-sm" _iid="{{$v->id}}" title="Delete interview also will remove associated quizes too">Delete</button>
                <a class="btn btn-info btn-sm" href="/admin/review?search-select={{$v->id}}" title="Explor interview result/reviews">Result</a>
                <!--<a class="btn btn-danger" href="/admin/interview/toggle?it={{$v->id}}" title="{{intval($v->active_status)?'Currently actived':'Currently inactived'}}">{{intval($v->active_status)?'Inactive':'Active'}}</a>-->
            </div>
        </div>
    </div>
</div>
@endforeach

<?php if(isset($i)){echo '</div>';}?>
<div class="modal interview-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Interview</h5>
            </div>
            <div class="modal-body">
                <form id="create-interview-form" method="post" enctype="multipart/form-data" target="save-frame">
                    @csrf
                    <input type="hidden" name="interview_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Instruction</label>
                                <textarea class="form-control" name="description" placeholder rows="2" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row m-sm">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label class="control-label" style="position:relative;">
                                    <button class="btn btn-info btn-xs" onclick="document.getElementById('preview_image').click();return false;">
                                        Upload Image
                                    </button>
                                    
                                    <input id="preview_image" name="preview_image" type="file" style="visibility:hidden;position: absolute;top: 0;" accept="image/*" title="Choose interview preview image">
                                </label>
                                <br>
                                <img class="preview-img " src="/app/interview_image/no-image.png">
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Candidate Time Period</label>
                                <div class="input-daterange input-group" data-plugin-datepicker style="position:relative;">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" name="ctt" data-date-format="yyyy-mm-dd" style="cursor: initial;" autocomplete="off" readonly required>
                                    <span class="error text-danger error-ctt hide" style="position:absolute;left:240px;top:5px;width:100px;">Invalid date</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label text-right">Assessor Time Period</label>
                                <div class="input-daterange input-group" data-plugin-datepicker style="position:relative;">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" name="att" data-date-format="yyyy-mm-dd" style="cursor: initial;" autocomplete="off" readonly required>
                                    <span class="error text-danger error-att hide" style="position:absolute;left:240px;top:5px;width:100px;">Invalid date</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assessor</label>
                                <select name="assessor[]" data-placeholder="Choose assessor..." class="form-control assessor-selector" multiple>
                                    <option></option>
                                    @foreach($assessors as $ass)
                                    <option value="{{$ass->id}}">{{$ass->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Create" form="create-interview-form">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
<iframe name="save-frame" style="display:none;"></iframe>

@section('scripts')
<script src="/plugins/chosen_v1.8.7/chosen.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var currentDate = '{{date('Ymd')}}';
    $.fn.datepicker.defaults.format = "dd.mm.yyyy";
    $('select[name="assessor[]"]').chosen({width: "95%"})

    $('.update-trigger').click(function (e) {
        $('.interview-modal .modal-title').text('Update Interview');
        $('.interview-modal input[type="submit"]').val('Update');
        $('#create-interview-form input[name="interview_id"]').val($(this).attr('_iid'));
        $('#create-interview-form input[name="name"]').val($('.interview-' + $(this).attr('_iid')).text());
        $('#create-interview-form textarea[name="description"]').val($(this).parent().siblings('.it-description').html());
        $('#create-interview-form select[name="assessor[]"]').val($(this).parent().siblings('.it-assessor').attr('ass').split(','));

        var att = $('span', $(this).parent().siblings('.it-assessor')).text();
        var ctt = $('span', $(this).parent().siblings('.it-candidate')).text();
        
        if(ctt.split('.').reverse().join('')<currentDate){
            $('input[name="ctt"]').val(ctt);
        }else{
            $('input[name="ctt"]').datepicker("setDate", ctt);
        }
        
        if(att.split('.').reverse().join('')<currentDate){
            $('input[name="att"]').val(att);
        }else{
            $('input[name="att"]').datepicker("setDate", att);
        }
        
        $('select[name="assessor[]"]').chosen().trigger("chosen:updated");
    });

    $('.create-trigger').click(function (e) {
        $('.interview-modal .modal-title').text('Create Interview');
        $('.interview-modal input[type="submit"]').val('Create');
        $('#create-interview-form input[name="interview_id"]').val('');
        $('#create-interview-form').trigger('reset');
        $('#create-interview-form select[name="assessor[]"]').val([]);
        $('.error-att,.error-ctt').addClass('hide');
        $('select[name="assessor[]"]').chosen().trigger("chosen:updated");
    });

    $('.delete-trigger').click(function (e) {
        if (!confirm('Are you sure delete this interview?'))
            return;

        $.get('/admin/interview/delete', {id: $(this).attr('_iid')}, function (id) {
            location.reload();
        });
    });

    $('#preview_image').change(function () {
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.preview-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else
        {
            $('.preview-img').attr('src', '/app/interview_image/no-image.png');
        }
    });

    $('#create-interview-form').submit(function(){
        if(!$('input[name="ctt"]').val()){
            alert('Please set time period for candidates.');
            $('input[name="ctt"]').click()
            return false;
        }

        if(!$('input[name="att"]').val()){
            alert('Please set time period for assessors.');
            $('input[name="att"]').click()
            return false;
        }

        if(!$('.error-ctt').hasClass('hide') || !$('.error-att').hasClass('hide')){
            return false;
        }
        
        return true;
    })
    
    $('input[name=startd],input[name=endd]').change(function(){
        $('#search-form').submit();
    })
    
    $('input[name="ctt"],input[name="att"]').on('changeDate', function(){
        if(arguments.length && !periodCheck(this.value)){
            $(this).next().removeClass('hide');
            return false;
        }
        $(this).datepicker('hide');
        $(this).next().addClass('hide');
        return true;
    });
    
    function periodCheck(v){
        return v.split('.').reverse().join('')>=currentDate;
    }
</script>
@endsection