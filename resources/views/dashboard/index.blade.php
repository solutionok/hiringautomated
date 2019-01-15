 @extends('layouts.page')
@section('css')
<style>
    
</style>
@endsection
@section('content')

@if(auth()->user()->isadmin==1)
<div class="row">
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-primary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                            <img src="/assets/images/interview.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="color:#0000aa; font-weight:bold; font-size:24px">Interviews</h4>
                            <div class="info">
                                <strong class="amount">{{$interviewCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="/admin/interview" class="text-uppercase" style="color:#f84d00; font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-secondary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-secondary">
                            <img src="/assets/images/review.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="color:#0000aa; font-weight:bold; font-size:24px">Reviews</h4>
                            <div class="info">
                                <strong class="amount">{{$reviewCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="/admin/review" class="text-uppercase" style="color:#f84d00; font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-tertiary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-tertiary">
                            <img src="/assets/images/assessor.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="color:#0000aa; font-weight:bold; font-size:24px">Assessors</h4>
                            <div class="info">
                                <strong class="amount">{{$assessorCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="/admin/assessor" class="text-uppercase" style="color:#f84d00; font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel panel-featured-left panel-featured-quartenary">
            <div class="panel-body">
                <div class="widget-summary">
                    <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-quartenary">
                            <img src="/assets/images/candidate.png" aria-hidden="true">
                        </div>
                    </div>
                    <div class="widget-summary-col">
                        <div class="summary">
                            <h4 class="title" style="color:#0000aa; font-weight:bold; font-size:24px">Candidates</h4>
                            <div class="info">
                                <strong class="amount">{{$candidateCount}}</strong>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <a href="/admin/candidate" class="text-uppercase" style="color:#f84d00; font-weight:bold; font-size:12px">view all</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endif
<div class="row">
    <div class="{{auth()->user()->isadmin==1?'col-md-6 col-sm-12':'col-md-12 col-sm-12'}}">
        <section class="panel">
            <header class="panel-heading" style="background-color:#000088;">
                <h2 class="panel-title" style="color:#ffffff; font-weight:bold; font-size:24px">
                    Not Reviewed Interviews
                </h2>
            </header>
            <div class="panel-body" style="background-color:#73c6b6;">
                <div class="table-responsive">
                    <table class="table mb-none">
                        <thead class="" style="background-color:#4444dd; color:#ffffff; font-weight:bold;">
                        <th>S.No</th>
                        <th>Candidate</th>
                        <th>Interview</th>
                        <th>Interview Date</th>
                        </thead>
                        <tbody style="background-color:#ffffff;">
                            @foreach($interviews as $i=>$q)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>
                                    <a href="/admin/review/{{$q->id}}">
                                        <img src="/{{!empty($q->photo)?$q->photo:'app/candidate/user.jpg'}}" style="width:30px;height:30px;"><nobr>{{$q->candidaten}}</nobr>
                                    </a>
                                </td>
                                <td>{{$q->interviewn}}</td>
                                <td>{{LT2IT($q->rundate)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @if(auth()->user()->isadmin==1)
    <div class="col-md-6 col-sm-12">
        <section class="panel">
            <header class="panel-heading" style="background-color:#000088;">
                <h2 class="panel-title" style="color:#ffffff; font-weight:bold; font-size:24px">
                    Not Appeared Candidates
                </h2>
            </header>
            <div class="panel-body" style="background-color:#73c6b6;">
                <div class="table-responsive">
                    <table class="table mb-none">
                        <thead class="" style="background-color:#4444dd; color:#ffffff; font-weight:bold;">
                        <th>S.No</th>
                        <th>Candidate</th>
                        <th>Interview</th>
                        </thead>
                        <tbody style="background-color:#ffffff;">
                            @foreach($intTemplates as $i=>$q)
                            <tr>
                                <td>{{$i+1}}</td>
                                <td>
                                    <a href="/admin/candidate/view?id={{$q->candidate_id}}">
                                        <img src="/{{!empty($q->photo)?$q->photo:'app/candidate/user.jpg'}}" style="width:30px;height:30px;"><nobr>{{$q->candidaten}}</nobr>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $q->interviewn?>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endif
</div>

@endsection

@section('scripts')
<script type="text/javascript">

</script>
@endsection