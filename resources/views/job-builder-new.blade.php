<!DOCTYPE html>
<link lang="en">

@include('job-builder-partials.styles')

<body>

<div id="preloader">
    <div data-loader="circle-side"></div>
</div><!-- /Preload -->

<div id="loader_form">
    <div data-loader="circle-side-2"></div>
</div><!-- /loader_form -->

<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div id="logo_home">
                    <h1><a href="{{asset('/')}}">STEPS | Multipurpose Working Wizard with Branches</a></h1>
                </div>
            </div>
            <div class="col-9">
                <div id="social">
                    <ul>
                        <li><a href="#0"><i class="icon-facebook"></i></a></li>
                        <li><a href="#0"><i class="icon-twitter"></i></a></li>
                        <li><a href="#0"><i class="icon-google"></i></a></li>
                        <li><a href="#0"><i class="icon-linkedin"></i></a></li>
                    </ul>
                </div>
                <!-- /social -->
                <nav>
                    <ul class="cd-primary-nav">
                        <li><a href="about.html" class="animated_link">About</a></li>
                        <li><a href="contacts.html" class="animated_link">Contacts</a></li>
                        <li><a href="icon-pack-1.html" class="animated_link">Icon Pack One</a></li>
                        <li><a href="icon-pack-2.html" class="animated_link">Icon Pack Two</a></li>
                        <li><a href="icon-pack-3.html" class="animated_link">Icon Pack Three</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- /container -->
    <style>
        .magicsearch-box{
            top: 40px !important;
            height: auto !important;
            width: 340px !important;
        }
    </style>
</header>
<!-- /Header -->

<main>
    <div class="container">
        <div id="wizard_container">
            <form name="example-1" id="wrapped" enctype="multipart/form-data" action="post-job-application" method="POST">
                <input id="website" name="website" type="text" value="">
                <!-- Leave for security protection, read docs for details -->
                <div id="middle-wizard">
                    @if(session()->has('success-message'))
                        <div class="alert alert-success">
                            {{ session()->get('success-message') }}
                        </div>
                    @endif

                    @if(session()->has('error-message'))
                        <div class="alert alert-error">
                            {{ session()->get('error-message') }}
                        </div>
                    @endif
                    <div class="step">


                        <div class="question_title">
                            <h3>What Type of job are you looking for ?</h3>
                            <p>Pick your Industry</p>

                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-4">
                                <div class="item">
                                    <input id="answer_1" type="radio" name="industry[]" value="Seo-Optimization" class="required">
                                    <label for="answer_1"><img src="{{ asset('public/img/technology.svg') }}" alt=""><strong>Technology</strong>Postea democritum mnesarchum ne nam, ad vim aperiri tractatos.</label>
                                </div>
                            </div>
                            {{--<div class="col-lg-4">--}}
                                {{--<div class="item">--}}
                                    {{--<input id="answer_2" name="industry[]" type="radio" value="Web-Development" class="required">--}}
                                    {{--<label for="answer_2"><img src="{{ asset('public/img/engineering.svg') }}" alt=""><strong>Engineering</strong>Postea democritum mnesarchum ne nam, ad vim aperiri tractatos.</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <!-- /row-->
                    </div>

                    <div class="step">
                        <div class="question_title">
                            <h3>Position</h3>
                            <p>Pick your position</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="box_general">
                                    <div class="form-group select">
                                        <label>Position</label>
                                        <div class="styled-select">
                                            <select class="required" name="position">
                                                <option value="" selected>Select</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position }}">{{ $position }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <!-- /box_general -->
                            </div>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /step-->

                    <div class="step">
                        <div class="question_title">
                            <h3>Role</h3>
                            <p>Pick your role</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="box_general">
                                    <div class="form-group select">
                                        <label>Role</label>
                                        <div class="styled-select">
                                            <select class="required" name="role">
                                                <option value="" selected>Select</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /select-->
                                    {{--<div class="form-group select">--}}
                                        {{--<label>Industry</label>--}}
                                        {{--<div class="styled-select">--}}
                                            {{--<select class="required" name="indust">--}}
                                                {{--<option value="" selected>Select</option>--}}
                                                {{--<option value="Unix/Linux + Mysql">Unix/Linux + Mysql</option>--}}
                                                {{--<option value="Windows + Sql">Windows + Sql</option>--}}
                                                {{--<option value="Other">Other</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    <!-- /select-->
                                    {{--<div class="form-group select">--}}
                                        {{--<label>Environment</label>--}}
                                        {{--<div class="styled-select">--}}
                                            {{--<select class="required" name="environment">--}}
                                                {{--<option value="" selected>Select</option>--}}
                                                {{--@foreach ($environments as $environment)--}}
                                                    {{--<option value="{{ $environment }}">{{ $environment }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                </div>
                                <!-- /box_general -->
                            </div>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /step-->

                    <div class="step">
                        <div class="question_title">
                            <h3>Environment</h3>
                            <p>Pick your Environment</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="box_general">
                                    <div class="form-group select">
                                        <label>Environment</label>
                                        <div class="styled-select">
                                            <select class="required" name="environment">
                                                <option value="" selected>Select</option>
                                                @foreach ($environments as $environment)
                                                    <option value="{{ $environment }}">{{ $environment }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <!-- /box_general -->
                            </div>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /step-->


                    <div class="step">
                        <div class="question_title">
                            <h3>Your Stack & Skills</h3>
                            <p>Pick your Stack</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="box_general">
                                    <div class="form-group select">
                                        <label>Stack</label>
                                        <div class="styled-select">
                                            <select class="required" name="stack">
                                                <option value="" selected>Select</option>
                                                @foreach ($stacks as $stack)
                                                    <option value="{{ $stack }}">{{ $stack }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group ">
                                    <label>Key Skills</label>

                                        <div>
                                            <input style="width: 340px !important; height: 40px !important;" class="magicsearch" name="key_skills" id="basic" placeholder="search skill...">
                                            {{--<select  class="required"  name="key_skills">--}}
                                            {{--<option value="" selected>Select</option>--}}
                                                {{--@foreach ($skills as $skill)--}}
                                                    {{--<option value="{{ $skill }}">{{ $skill }}</option>--}}
                                                {{--@endforeach--}}
                                            {{--</select>--}}
                                        </div>
                                    </div>

                                </div>
                                <!-- /box_general -->
                            </div>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /step-->

                    <!-- Budget ============================== -->
                    <div class="step">
                        <div class="question_title">
                            <h3>What's your current or expected salary?</h3>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="box_general">
                                    <div class="rounded_slider">
                                        <div id="budget_slider" style="margin: 0 auto 20px;"></div>
                                        <p>Eu sed epicuri mentitum, ex mei hinc justo, no cum dictas deserunt gubergren. Ferri pericula sententiae eu pro.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /Budget ============================== -->

                    <!-- Last step ============================== -->

                    <div class="submit step">
                        <div class="question_title">
                            <h3>Plase fill with your details</h3>
                            <p>Ei duo homero postea dignissim.</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="box_general">
                                    <div class="form-group">
                                        <input type="text" name="first_name" class="required form-control" placeholder="First Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="last_name" class="required form-control" placeholder="Last Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="required form-control" placeholder="Your Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="telephone" class="form-control" placeholder="Your Telephone">
                                    </div>
                                    <div class="form-group add_bottom_30">
                                        <div class="styled-select">
                                            <select class="required" name="country">
                                                <option value="" selected>Select your country</option>
                                                <option value="Europe">Europe</option>
                                                <option value="Asia">Asia</option>
                                                <option value="North America">North America</option>
                                                <option value="South America">South America</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="custom-file-label" for="customFile">EU Work Permit</label>
                                        <label class="radio"><input type="radio" name="permit" value="Yes">Yes</label>
                                        <label class="radio"><input type="radio" name="permit" checked="checked"  value="No">NO</label>

                                    </div>
                                    <div class="form-group">
                                        <label class="custom-file-label" for="customFile">Upload your Resume</label>
                                        <input type="file" name="resume" class="required form-control" id="customFile">

                                    </div>
                                    <div class="checkbox_questions">
                                        <input name="terms" type="checkbox" class="icheck required" value="yes">
                                        <label>Please accept <a href="#" data-toggle="modal" data-target="#terms-txt">terms and conditions</a>.</label>
                                    </div>

                                </div>
                                <!-- /box_general -->
                            </div>
                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /Last step ============================== -->
                </div>
                <!-- /middle-wizard -->
                <div id="bottom-wizard">
                    <button type="button" name="backward" class="backward">Backward </button>
                    <button type="button" name="forward" class="forward">Forward</button>
                    <button type="submit" name="process" class="submit">Submit</button>
                </div>
                <!-- /bottom-wizard -->
            </form>
        </div>
        <!-- /Wizard container -->
    </div>
    <!-- /Container -->
</main>
<!-- /main -->

<footer>
    <div class="container clearfix">
        <ul>
            <li><a href="{{asset('/')}}" class="animated_link"> << Back to Website</a></li>

        </ul>
        <p>© 2017 elephant-hr</p>
    </div>
</footer>
<!-- /footer -->

<div class="cd-overlay-nav">
    <span></span>
</div>
<!-- /cd-overlay-nav -->

<div class="cd-overlay-content">
    <span></span>
</div>
<!-- /cd-overlay-content -->

<!-- /cd-nav-trigger -->

<!-- Modal terms -->
<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsLabel">Terms and conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Lorem ipsum dolor sit amet, in porro albucius qui, in <strong>nec quod novum accumsan</strong>, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
                <p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus. Lorem ipsum dolor sit amet, <strong>in porro albucius qui</strong>, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
                <p>Lorem ipsum dolor sit amet, in porro albucius qui, in nec quod novum accumsan, mei ludus tamquam dolores id. No sit debitis meliore postulant, per ex prompta alterum sanctus, pro ne quod dicunt sensibus.</p>
            </div>
        </div>
    </div>
</div>
<!-- /Modal terms -->

<!-- COMMON SCRIPTS -->
@include('job-builder-partials.scripts')
<script>
$(document).ready(function() {

    var dataSource = [];
    $.ajax({
        type: "GET",
        url: "http://localhost/elephant/get-skills",
        data: {'lang' : 'en'},
        success: function(data){
            for(var i=0; i < data.length; i++){
                dataSource.push(data[i]);
            }

        }
    });

    console.log("res", dataSource);
    $('#basic').magicsearch({
        dataSource: dataSource,
        fields: ['skill'],
        id: 'id',
        format: '%skill%',
        multiple: true,
        multiField: 'skill',
        showSelected: true,
        multiStyle: {
            space: 5,
            width: 80
        },
        success: function($input, data) {
            console.log('data-yes', data.skill);
            // $('.magicsearch').val(data.skill);
            // $('input[name="key_skills"]').val('some value')

        }
});

});
</script>
</body>


</html>