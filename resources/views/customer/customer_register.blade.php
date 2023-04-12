{{--
    LAYOUT YIELDS :

    A. HTML HEAD :
    1.  pagename : nama halaman ini (you dont say)
    2.  custom_css : jika butuh import custom css yang dibuat sendiri
    3.  dependencies : jika butuh import dependencies khusus page ini cth bootstrap, jquery

    B. HTML BODY :
    4.  header : untuk konten" header cth navbar, alert, error dsb
    5.  content : konten" utama halaman ini
    6.  footer

    C. OUTSIDE HTML BODY :
    7.  js_script

--}}

@extends('layouts.layout')

@section('pagename')
    Portable
@endsection

@section('custom_css')
    <link rel="stylesheet" href="{{asset('build/css/customer_home.css')}}">
    <style>
        .navigation:hover{
            transform: scale(1.2);
            font-weight: 600;
            cursor: pointer;
        }
    </style>
@endsection

@section('dependencies')
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@endsection

@section('content')
@include("partial.flashMessage")
<div class="container">
        {{-- NAVBAR --}}
        @include('customer.partial.navbar')
        {{-- FORM --}}
        <div class="row m-0">
            <div class="col-sm-12 col-lg-8 bg-dark text-light px-4 py-3 overflow-auto" style="height: calc(100vh - 80px)">
                <div class="head mb-2">
                        <h3 style="font-family: helvetica_bold;">Terms and Conditions</h3>
                        <p class="m-0 text-secondary">
                            What’s covered in these terms We know it’s tempting to skip these Terms of Service, but it’s important to establish what you can expect from us as you use PorTable services, and what we expect from you.
                        </p>
                </div>

                <div class="subsection mb-2">
                    <h4>(1) About these terms</h4>
                    <p style="font-size: 0.9em">
                        By law, you have certain rights that can’t be limited by a contract like these terms of service. These terms are in no way intended to restrict those rights.
                        These terms describe the relationship between you and Google. They don’t create any legal rights for other people or organizations, even if others benefit from that relationship under these terms
                        We want to make these terms easy to understand, so we’ve used examples from our services. But not all services mentioned may be available in your country.
                        If these terms conflict with the service-specific additional terms, the additional terms will govern for that service.
                        If it turns out that a particular term is not valid or enforceable, this will not affect any other terms.
                        If you don’t follow these terms or the service-specific additional terms, and we don’t take action right away, that doesn’t mean we’re giving up any rights that we may have, such as taking action in the future.
                        We may update these terms and service-specific additional terms (1) to reflect changes in our services or how we do business — for example, when we add new services, features, technologies, pricing, or benefits (or remove old ones), (2) for legal, regulatory, or security reasons, or (3) to prevent abuse or harm.
                        If we materially change these terms or service-specific additional terms, we’ll provide you with reasonable advance notice and the opportunity to review the changes, except (1) when we launch a new service or feature, or (2) in urgent situations, such as preventing ongoing abuse or responding to legal requirements. If you don’t agree to the new terms, you should remove your content and stop using the services. You can also end your relationship with us at any time by closing your Google Account.
                    </p>
                </div>
                <div class="subsection mb-2">
                    <h4>(2) For business users and organizations only</h4>
                    <p style="font-size: 0.9em">
                        To the extent allowed by applicable law, you’ll indemnify Google and its directors, officers, employees, and contractors for any third-party legal proceedings (including actions by government authorities) arising out of or relating to your unlawful use of the services or violation of these terms or service-specific additional terms. This indemnity covers any liability or expense arising from claims, losses, damages, judgments, fines, litigation costs, and legal fees.
                        If you’re legally exempt from certain responsibilities, including indemnification, then those responsibilities don’t apply to you under these terms. For example, the United Nations enjoys certain immunities from legal obligations and these terms don’t override those immunities.
                        Google won’t be responsible for the following liabilities:
                        loss of profits, revenues, business opportunities, goodwill, or anticipated savings
                        indirect or consequential loss
                        punitive damages
                        Google’s total liability arising out of or relating to these terms is limited to the greater of (1) US$500 or (2) 125% of the fees that you paid to use the relevant services in the 12 months before the breach
                        Taking action in case of problems
                        Before taking action as described below, we’ll provide you with advance notice when reasonably possible, describe the reason for our action, and give you an opportunity to fix the problem, unless we reasonably believe that doing so would:
                        cause harm or liability to a user, third party, or Google
                        violate the law or a legal enforcement authority’s order
                        compromise an investigation
                        compromise the operation, integrity, or security of our services
                        Removing your content
                        If we reasonably believe that any of your content (1) breaches these terms, service-specific additional terms or policies, (2) violates applicable law, or (3) could harm our users, third parties, or Google, then we reserve the right to take down some or all of that content in accordance with applicable law. Examples include child pornography, content that facilitates human trafficking or harassment, terrorist content, and content that infringes someone else’s intellectual property rights.
                    </p>
                </div>
                <div class="subsection mb-2">
                    <h4>(3) Content in PorTable</h4>
                    <p style="font-size: 0.9em">
                        Your content
                        Some of our services give you the opportunity to make your content publicly available — for example, you might post a product or restaurant review that you wrote, or you might upload a blog post that you created.
                        See the Permission to use your content section for more about your rights in your content, and how your content is used in our services
                        See the Removing your content section to learn why and how we might remove user-generated content from our services
                        If you think someone is infringing your intellectual property rights, you can send us notice of the infringement and we’ll take appropriate action. For example, we suspend or close the Google Accounts of repeat copyright infringers as described in our Copyright Help Center.
                    </p>
                </div>
                {{-- CHECK --}}
                <hr>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="toggleCheckbox()">
                    <label class="form-check-label" for="exampleCheck1">I have read and agree with PorTable's Terms and Agreements</label>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 px-4 py-3 overflow-auto" style="height: calc(100vh - 80px)">
                <div class="text-center">
                    <h3 style="font-family: helvetica_bold;">Restaurant Details</h3>
                </div>
                {{-- FORM --}}
                <form action="/customer/register_restaurant/do_register" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- NAME --}}
                    <div class="mb-3">
                        <label class="form-label">Restaurant name</label>
                        <input type="text" class="form-control" placeholder="Input your restaurant fullname here..." name="full_name" value="{{old('full_name')}}">

                        @error('full_name')
                            @include('partial.validationMessage')
                        @enderror
                    </div>
                    {{-- PHONE ADDRESS --}}
                    <div class="row m-0">
                        <div class="col ps-0">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="Restaurant address..." name="address" value="{{old('address')}}">

                                @error('address')
                                    @include('partial.validationMessage')
                                @enderror
                            </div>
                        </div>
                        <div class="col pe-0">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" placeholder="Phone number..." name="phone" value="{{old('phone')}}">

                                @error('phone')
                                    @include('partial.validationMessage')
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- IMAGE --}}
                    <div class="mb-2">
                        <label class="form-label">Upload restaurant photo(3 files of jpg/png/jpeg): </label>
                        <input type="file" name="foto[]" id="" class="form-control" multiple>
                        @error('foto')
                            @include('partial.validationMessage')
                        @enderror
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-2">Description</div>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" name="description">{{old('description')}}</textarea>
                        <label for="floatingTextarea2">Description e.g : Asian, Steak, etc</label>
                    </div>
                    {{-- OPEN TIME, SHIFTS --}}
                    <div class="row m-0 mt-2">
                        <div class="col ps-0">
                            <div class="mb-3">
                                <label class="form-label">Open at</label>
                                <input type="number" class="form-control" max="23" min="0" placeholder="Time your restaurant open..." name="open_at" value="{{old('open_at')}}">

                                @error('open_at')
                                    @include('partial.validationMessage')
                                @enderror
                            </div>
                        </div>
                        <div class="col pe-0">
                            <div class="mb-3">
                                <label class="form-label">Shifts</label>
                                <input type="number" class="form-control" placeholder="Shifts with 1 hour interval..." name="shift" value="{{old('shift')}}">

                                @error('shift')
                                    @include('partial.validationMessage')
                                @enderror
                            </div>
                        </div>
                    </div>

                    <input class="btn me-2 w-100 mt-2 disabled" id="submit" type="submit" style="background-color: #ed3b27;color:white;" value="Create Restaurant Account">
                    <div class="text-secondary">* Please check the i have read and agree with PorTable's Terms and Agreements checkbox</div>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="about_us bg-dark text-light">
        <div class="container">
            <div class="copyright text-center">
                <p class="m-0 py-3" style="color: rgb(200, 200, 200);">
                    &copy; 2022. Institut Sains dan Teknologi Terpadu Surabaya
                </p>
            </div>
        </div>
    </div> --}}
@endsection

@section('js_script')

    <script>
        $(document).ready(function(){
            console.log('Welcome Customer!');
        });

        var agree = false;
        function toggleCheckbox(){
            if(!agree){
                $("#submit").removeClass("disabled");
            }else{
                $("#submit").addClass("disabled");
            }
            agree = !agree;
        }
    </script>
@endsection
