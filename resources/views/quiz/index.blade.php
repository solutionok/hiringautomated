@extends('layouts.page')
@section('css')
<link rel="stylesheet" href="/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<style>
    .table-responsive {
        overflow-x: hidden;
    }
    div.dataTables_length select {
        padding: 5px 10px!important;
        text-align: center;
        width: auto;
        height: auto;
    }
    .dataTables_wrapper .dataTables_filter label{width:100%;}
    .dataTables_wrapper .dataTables_filter input {
        display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555555;
        background-color: #ffffff;
        background-image: none;
        border: 1px solid #cccccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
        -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    }
    .dataTables_wrapper .dataTables_filter input{
        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PHN2ZyAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgICB4bWxuczpzdmc9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgICB2ZXJzaW9uPSIxLjEiICAgaWQ9InN2ZzQ0ODUiICAgdmlld0JveD0iMCAwIDIxLjk5OTk5OSAyMS45OTk5OTkiICAgaGVpZ2h0PSIyMiIgICB3aWR0aD0iMjIiPiAgPGRlZnMgICAgIGlkPSJkZWZzNDQ4NyIgLz4gIDxtZXRhZGF0YSAgICAgaWQ9Im1ldGFkYXRhNDQ5MCI+ICAgIDxyZGY6UkRGPiAgICAgIDxjYzpXb3JrICAgICAgICAgcmRmOmFib3V0PSIiPiAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9zdmcreG1sPC9kYzpmb3JtYXQ+ICAgICAgICA8ZGM6dHlwZSAgICAgICAgICAgcmRmOnJlc291cmNlPSJodHRwOi8vcHVybC5vcmcvZGMvZGNtaXR5cGUvU3RpbGxJbWFnZSIgLz4gICAgICAgIDxkYzp0aXRsZT48L2RjOnRpdGxlPiAgICAgIDwvY2M6V29yaz4gICAgPC9yZGY6UkRGPiAgPC9tZXRhZGF0YT4gIDxnICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLC0xMDMwLjM2MjIpIiAgICAgaWQ9ImxheWVyMSI+ICAgIDxnICAgICAgIHN0eWxlPSJvcGFjaXR5OjAuNSIgICAgICAgaWQ9ImcxNyIgICAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjAuNCw4NjYuMjQxMzQpIj4gICAgICA8cGF0aCAgICAgICAgIGlkPSJwYXRoMTkiICAgICAgICAgZD0ibSAtNTAuNSwxNzkuMSBjIC0yLjcsMCAtNC45LC0yLjIgLTQuOSwtNC45IDAsLTIuNyAyLjIsLTQuOSA0LjksLTQuOSAyLjcsMCA0LjksMi4yIDQuOSw0LjkgMCwyLjcgLTIuMiw0LjkgLTQuOSw0LjkgeiBtIDAsLTguOCBjIC0yLjIsMCAtMy45LDEuNyAtMy45LDMuOSAwLDIuMiAxLjcsMy45IDMuOSwzLjkgMi4yLDAgMy45LC0xLjcgMy45LC0zLjkgMCwtMi4yIC0xLjcsLTMuOSAtMy45LC0zLjkgeiIgICAgICAgICBjbGFzcz0ic3Q0IiAvPiAgICAgIDxyZWN0ICAgICAgICAgaWQ9InJlY3QyMSIgICAgICAgICBoZWlnaHQ9IjUiICAgICAgICAgd2lkdGg9IjAuODk5OTk5OTgiICAgICAgICAgY2xhc3M9InN0NCIgICAgICAgICB0cmFuc2Zvcm09Im1hdHJpeCgwLjY5NjQsLTAuNzE3NiwwLjcxNzYsMC42OTY0LC0xNDIuMzkzOCwyMS41MDE1KSIgICAgICAgICB5PSIxNzYuNjAwMDEiICAgICAgICAgeD0iLTQ2LjIwMDAwMSIgLz4gICAgPC9nPiAgPC9nPjwvc3ZnPg==);
        background-repeat: no-repeat;
        background-color: #fff;
        background-position: 3px 6px !important;
        padding-left: 25px;    }
</style>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">{{$interview->name}} Questions</h4>
            </div>
            <div class="panel-body">
                <p class="btn-bar">
                    <button onclick="javascript:location.href = '/admin/interview';" class="btn btn-danger">Back</button>
                    <button class="btn btn-primary create-quiz-trigger">Add Questions <i class="fa fa-plus"></i></button>
                </p>

                <div class="table-responsive">
                    <table class="question-table table table-bordered table-striped mb-none dataTable no-footer">
                        <thead>
                        <th>#</th>
                        <th>Questions</th>
                        <th>Type</th>
                        <th class="text-right">Preparation Time</th>
                        <th class="text-right">Response Time</th>
                        <th class="text-right">Maximum Score</th>
                        <th class="text-center">Action</th>
                        </thead>
                        <tbody>
                            <?php
                            function s2ms($s) {
                                return gmdate("i:s", $s);
                            }
                            ?>
                            @foreach($quizList as $i=>$q)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>{{$q->description}}</td>
                                <td>{{$qtypes[$q->qtype]}}</td>
                                <td class="text-right">{{$q->qprepare?s2ms($q->qprepare):'-'}}</td>
                                <td class="text-right">{{$q->qtime?s2ms($q->qtime):'-'}}</td>
                                <td class="text-right">{{$q->grade}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <nobr>
                                        <a class="btn btn-default btn-sm update-quiz-trigger" _iid="{{$q->id}}" title="Edit question, type time.."><i class="fa fas fa-edit"></i> </a>
                                        <a class="btn btn-default btn-sm delete-quiz-trigger" _iid="{{$q->id}}" title="Remove this question"><i class="fa fa-trash"></i> </a>
                                        <a class="btn btn-default btn-sm" href="/admin/quiz/moveq/{{$q->id}}" title="Move up this question"><i class="fa fa-arrow-up"></i> </a>
                                        <a class="btn btn-default btn-sm" href="/admin/quiz/moveq/-{{$q->id}}" title="Move down this question"><i class="fa fa-arrow-down"></i> </a>
                                        </nobr>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade quiz-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:90%;max-width:1200px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Question</h5>
            </div>
            <div class="modal-body">
                <form id="create-quiz-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="quiz_id">
                    <input type="hidden" name="qdetail">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Question</label>
                                <textarea style="width:100%;height:100px;" name="description" required=""></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label style="position:relative;">
                                            <button class="btn btn-info btn-xsa" onclick="document.getElementById('attach_media').click();return false;">
                                                Attach Media
                                            </button>
                                            <input id="attach_media" name="attach_media" type="file" style="visibility:hidden;position: absolute;top: 0;" accept="image/*,audio/mp3,video/mp4">
                                        </label>
                                        <code>mp3, mp4, image only</code>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label>Question Type</label>
                                        <select class="form-control" name="qtype" placeholder="" required="">
                                            @foreach($qtypes as $qtid=>$qtname)
                                            <option value="{{$qtid}}">{{$qtname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 choice-count">
                                        <label>Choice Count</label>
                                        <input type="number" max="10" min="2" class="form-control" value="2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Maximum Score</label>
                                        <input name="grade" type="number" min="1" class="form-control" value="1" required="">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Preparation Time(mm:ss)</label>
                                        <input name="qprepare" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Response Time(mm:ss)</label>
                                        <input name="qtime" type="text" class="form-control" step="15" required="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="choice-hr">

                    <div class="row choice-problems">
                        <div class="col-md-12">
                            <div class="input-group mb-md">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="choice-check">
                                </span>
                                <input type="text" name="choice-text" class="col-md-12" required>
                            </div>
                        </div>
                    </div>

                    <div class="row choice-problems">
                        <div class="col-md-12">
                            <div class="input-group mb-md">
                                <span class="input-group-addon">
                                    <input type="checkbox" name="choice-check">
                                </span>
                                <input type="text" name="choice-text" class="col-md-12" required>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="Create" form="create-quiz-form">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="/assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="/assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script type="text/javascript" src="/plugins/timepicker/timepicker.js"></script>
<script type="text/javascript">
    var Table = $('.question-table').dataTable({
    "columnDefs": [
        { "orderable": false, "targets": 0 },
        { "orderable": false, "targets": 6 },
      ]
    ,  
    "dom": '<"top"lf>t<"bottom"pi><"clear">',
    select: true,
    language: {
        searchPlaceholder: "Search "
    }
});

    $('input[name=qprepare],input[name=qtime]').mask('99:99');

    $('input[name=attach_media]').change(function () {
        $(this).parent().next().text($(this).val() ? this.files.item(0).name : 'mp3, mp4, image only');
    })

    $('.choice-count > input').change(function () {
        applyCounts();
    })

    function applyCounts() {
        if ($('select[name=qtype]').val() != '1' && $('select[name=qtype]').val() != '2')
            return false;

        var apply_count = $('.choice-count > input').val(),
                addcount = apply_count - $('.choice-problems').length,
                intype = $('select[name=qtype]').val() == '1' ? 'checkbox' : 'radio';

        if (addcount < 0) {
            $('.choice-problems').eq(apply_count - 1).nextAll().remove();
        } else if (addcount > 0) {
            var problemHtml = '<div class="row choice-problems">' +
                    '<div class="col-md-12">' +
                    '<div class="input-group mb-md">' +
                    '<span class="input-group-addon">' +
                    '<input type="checkbox" name="choice-check">' +
                    '</span>' +
                    '<input type="text"  name="choice-text" class="col-md-12" required>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            while (addcount > 0) {
                $('#create-quiz-form').append(problemHtml);
                addcount--;
            }
        }

        $('.choice-problems').each(function (i, el) {
            $('input[name="choice-check"]', el).attr('type', intype).prop('checked', false);
        })
    }

    $('select[name=qtype]').change(function () {
        if (this.value == '1' || this.value == '2') {
            $('.choice-count,.choice-apply,.choice-problems,.choice-hr').show();
            $('.choice-problems input[name="choice-text"]').attr('disabled', false);
            $('input[name=qprepare]').val('00:00').prop('disabled', true);
        } else {
            $('.choice-count,.choice-apply,.choice-problems,.choice-hr').hide();
            $('.choice-problems input[name="choice-text"]').attr('disabled', true);
            $('input[name=qprepare]').prop('disabled', false);
        }

        applyCounts();
    });

    $('#create-quiz-form').submit(function () {
        if (($('select[name=qtype]').val() == '1' || $('select[name=qtype]').val() == '2')) {
            if (!$('input[name="choice-check"]:checked').length) {
                alert('Should checked one more choices!');
                return false;
            }

            var qdetail = {'ch': [], 'txt': []};
            $('input[name="choice-check"]').each(function (i, el) {
                qdetail.ch.push($(el).prop('checked') ? 1 : 0)
                qdetail.txt.push($(el).parent().next().val())
            })

            $('input[name=qdetail]').val(JSON.stringify(qdetail));
        }

        return true;
    })


    function s2m(value) {
        value = value * 1;
        var minutes = Math.floor(value / 60);
        var seconds = value % 60;

        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        return minutes + ':' + seconds;
    }

    $('.update-quiz-trigger').click(function () {
        $.get('/admin/quiz/getquiz/' + $(this).attr('_iid'), function (r) {
            $('textarea[name=description]').val(r['description']);

            if (r['attach_media']) {
                $('#create-quiz-form code').html('<a class="btn btn-danger" href="/' + r['attach_media'] + '" target="quiz-attach-media">View</a>');
            } else {
                $('#create-quiz-form code').html('mp3, mp4, image only');
            }

            $('input[name=grade]').val(r['grade']);
            $('input[name=qprepare]').val(s2m(r['qprepare']));
            $('input[name=qtime]').val(s2m(r['qtime']));
            $('select[name=qtype]').val(r['qtype']);

            if (r['qtype'] == '1' || r['qtype'] == '2') {

                var qdetail = JSON.parse(r['qdetail']);
                $('.choice-count input').val(qdetail['ch'].length);
                $('.choice-problems').remove();
                var apply_count = qdetail['ch'].length,
                        intype = r['qtype'] == '1' ? 'checkbox' : 'radio';

                for (var i = 0; i < apply_count; i++) {
                    var problemHtml = '<div class="row choice-problems">' +
                            '<div class="col-md-12">' +
                            '<div class="input-group mb-md">' +
                            '<span class="input-group-addon">' +
                            '<input type="' + intype + '" ' + (Number(qdetail['ch'][i]) > 0 ? 'checked' : '') + ' name="choice-check">' +
                            '</span>' +
                            '<input type="text"  name="choice-text" class="col-md-12" value="' + (qdetail['txt'][i]) + '">' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                    $('#create-quiz-form').append(problemHtml);
                }

                $('.choice-count,.choice-apply,.choice-problems').show();
                $('.choice-problems input[name="choice-text"]').prop('disabled', false);
                $('input[name="qprepare"]').prop('disabled', true);
            } else {
                $('.choice-count,.choice-apply,.choice-problems').hide();
                $('.choice-problems input[name="choice-text"]').prop('disabled', true);
                $('input[name="qprepare"]').prop('disabled', false);
            }

            $('.quiz-modal .modal-title').text('Update Question');
            $('.quiz-modal input[type="submit"]').val('Update');
            $('#create-quiz-form input[name="quiz_id"]').val(r['id']);


            $('.quiz-modal').modal();
        })

    })

    $('.delete-quiz-trigger').click(function () {
        if (!confirm('Are you sure delete this question?'))
            return;

        $.get('/admin/quiz/delete', {id: $(this).attr('_iid')}, function (id) {
            location.reload();
        });
    })

    $('.create-quiz-trigger').click(function () {
        $('.quiz-modal .modal-title').text('Create Question');
        $('.quiz-modal input[type="submit"]').val('Create');
        $('#create-quiz-form input[name="quiz_id"]').val('');
        $('#create-quiz-form').trigger('reset');
        $('select[name="qtype"]').val('1').trigger('change');
        $('.choice-apply input').val('2');
        $('.choice-apply a').trigger('click');
        $('#create-quiz-form code').html('mp3, mp4, image only');
        $('.quiz-modal').modal();
    })
</script>
@endsection