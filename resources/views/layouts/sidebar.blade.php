<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <!--if admin, assessor-->
                    @if(auth()->user()->isadmin!=0)
                    <li class="{{($pageName=='dashboard') ? 'nav-active' : '' }}">
                        <a href="/admin/dashboard">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='interview') ? 'nav-active' : '' }}" {{auth()->user()->isadmin!=1?'style=display:none;':''}}>
                        <a href="/admin/interview">
                            <img src="/assets/images/interview.png" aria-hidden="true">
                            <span>Interviews</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='review') ? 'nav-active' : '' }}">
                        <a href="/admin/review">
                            <img src="/assets/images/review.png" aria-hidden="true">
                            <span>Reviews</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='assessor') ? 'nav-active' : '' }}" {{auth()->user()->isadmin!=1?'style=display:none;':''}}>
                        <a href="/admin/assessor">
                            <img src="/assets/images/assessor.png" aria-hidden="true">
                            <span>Assessors</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='candidate') ? 'nav-active' : '' }}" {{auth()->user()->isadmin!=1?'style=display:none;':''}}>
                        <a href="/admin/candidate">
                            <img src="/assets/images/candidate.png" aria-hidden="true">
                            <span>Candidates</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='settings') ? 'nav-active' : '' }}">
                        <a href="/admin/settings">
                            <img src="/assets/images/settings.png" aria-hidden="true">
                            <span>Settings</span>
                        </a>
                    </li>
                    
                    <!--if candidate-->
                    @else
                    <li class="{{($pageName=='interview') ? 'nav-active' : '' }}">
                        <a href="/home/interview">
                            <img src="/assets/images/interview.png" aria-hidden="true">
                            <span>Interviews</span>
                        </a>
                    </li>
                    
                    <li class="{{($pageName=='profile') ? 'nav-active' : '' }}">
                        <a href="/home/mypage">
                            <img src="/assets/images/settings.png" aria-hidden="true">
                            <span>Profile</span>
                        </a>
                    </li>
                     @endif
                </ul>
            </nav>

        </div>

    </div>

</aside>