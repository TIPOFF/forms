@extends('website.layout')

@section('amp-scripts')
    @parent
    <script async custom-element="amp-recaptcha-input" src="https://cdn.ampproject.org/v0/amp-recaptcha-input-0.1.js"></script>
@endsection

@section('content')
    @include('website.subviews.covid-notice')

    <section class="tger-contact">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tger-contact__inner">
                        <form
                            method="post"
                            action-xhr="{{ $location->slug }}"
                            target="_top">
                            <fieldset>
                                @csrf
                                <input
                                    name="form_type"
                                    value="contact"
                                    type="hidden">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">First Name<span class="required">*</span></label>
                                            <input
                                                type="text"
                                                name="name"
                                                class="form-control"
                                                placeholder="Enter first name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Last Name<span class="required">*</span></label>
                                            <input
                                                type="text"
                                                name="name_last"
                                                class="form-control"
                                                placeholder="Enter last name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email<span class="required">*</span></label>
                                            <input
                                                type="email"
                                                name="email"
                                                class="form-control"
                                                placeholder="Enter your email"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Phone<span class="required">*</span></label>
                                            <input
                                                type="tel"
                                                name="phone"
                                                class="form-control"
                                                placeholder="Enter your phone"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Message</label>
                                            <textarea
                                                name="message"
                                                class="form-control"
                                                rows="4"
                                                placeholder="Enter your message">
                                                </textarea>
                                        </div>
                                        <div class="tger-button-container">
                                            <input
                                                value="Submit"
                                                class="button6"
                                                type="submit">
                                        </div>
                                    </div>
                                </div>
                                <amp-recaptcha-input layout="nodisplay"
                                                     name="recaptcha_token"
                                                     data-sitekey="{{ config('app.recaptcha_site') }}"
                                                     data-action="recaptcha_example">
                                </amp-recaptcha-input>
                            </fieldset>
                            <div submit-success>
                                <template type="amp-mustache">
                                    Message sent successfully!
                                </template>
                            </div>
                            <div submit-error>
                                <template type="amp-mustache">
                                    Submission failed!<br><br>
                                    @{{ #verifyErrors }}
                                    <p>@{{ message }}</p>
                                    @{{ /verifyErrors }}
                                </template>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
