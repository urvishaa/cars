@extends('layout')
@section('content')
<?php 
  $urlnew = url(''); 
  $new = str_replace('index.php', '', $urlnew);
  $session = Session::all();
  $contact = DB::table('get_touch')->first();
?>



 

   
    <!--== Page Title Area End ==-->

    <!--== Contact Page Area Start ==-->
    <div class="contact-page-wrao section-padding">
        <div class="container">
            <div class="section-title  text-center">
                 @if(session()->has('message'))
                  <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      {{ session()->get('message') }}
                  </div>
                  @endif
                   
                  @if(session()->has('errorMessage'))
                      <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          {{ session()->get('errorMessage') }}
                      </div>
                  @endif
                  <h2> {{ trans('labels.getTouch') }}</h2>
                    <span class="title-line"><i class="fa fa-car"></i></span>
            </div>

                        <!-- <h2>{{ trans('labels.contact') }}</h2> -->

            <div class="contact-info">
                <div class="contact-info-inr row">
                    <div class="col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-md-4 contact_col">
                                <div class="contact_info">
                                    <ul>
                                        <li class="d-flex flex-row align-items-center justify-content-start">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div><img src="{{ URL::to('/resources/assets/img/placeholder_2.svg')}}" alt=""></div>
                                            </div>
                                            <span>{{ $contact->address }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 contact_col">
                                <div class="contact_info">
                                    <ul>
                                        <li class="d-flex flex-row align-items-center justify-content-start">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div><img src="{{ URL::to('/resources/assets/img/phone-call-2.svg')}}" alt=""></div>
                                            </div>
                                            <span>{{ $contact->phone }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4 contact_col">
                                <div class="contact_info">
                                    <ul>
                                        <li class="d-flex flex-row align-items-center justify-content-start">
                                            <div class="d-flex flex-column align-items-center justify-content-center">
                                                <div><img src="{{ URL::to('/resources/assets/img/envelope-2.svg')}}" alt=""></div>
                                            </div>
                                            <span>{{ $contact->email }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="contact-form">
                        <form action="{{ URL::to('/contactstore') }}" method="post" class="contact_form text-center" id="contact_form">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="name-input">
                                        <input type="text" id="name" name="name" placeholder="{{ trans('labels.name') }}" required="required" autofocus>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="email-input">
                                        <input type="email" id="email" name="email" placeholder="{{ trans('labels.email') }}" required="required" autofocus="">
                                    </div>
                                </div>
                            </div>

                           

                            <div class="message-input">
                                <textarea id="message" name="message" rows="5" placeholder="{{ trans('labels.message') }}" required="required" autofocus=""></textarea>
                            </div>

                            <div class="input-submit">
                                <button type="submit">{{ trans('labels.sendMessage') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== Contact Page Area End ==-->

    <!--== Map Area Start ==-->
    <div class="maparea newmapp">
      
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6842023.921022298!2d39.211004914853106!3d33.13977811693436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1557823d54f54a11%3A0x6da561bba2061602!2sIraq!5e0!3m2!1sen!2sin!4v1567429118242!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                
    </div>
    <!--== Map Area End ==-->

    <script src="https://www.google.com/recaptcha/api.js?render=6LetCbkUAAAAAOTXEZhVXsj3FC1vw95krjYeu9sF"></script>
      <script>
           // when form is submit
        $('#comment_form').submit(function() {
            // we stoped it
            event.preventDefault();
            var email = $('#email').val();
            var name = $("#name").val();
            var message = $("#message").val();
            // needs for recaptacha ready
            grecaptcha.ready(function() {
                // do request for recaptcha token
                // response is promise with passed token
                grecaptcha.execute('6LetCbkUAAAAAOTXEZhVXsj3FC1vw95krjYeu9sF', {action: 'create_comment'}).then(function(token) {
                    // add token to form
                    $('#comment_form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                        $.post("{{ URL::to('/contactstore') }}",{email: email, name: name, message: message, token: token}, function(result) {
                                console.log(result);
                                if(result.success) {
                                        alert('Thanks for posting comment.')
                                       
                                } else {
                                        alert('You are spammer ! Get the @$%K out.')
                                }
                        });
                });;
            });
      });
      </script>
      
@endsection