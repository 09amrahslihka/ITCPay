@extends('User.dashboard.layouts.master')
@section('title', 'Privacy Policy')
@section('content')
    <div class="box box-info" <?php if(!isset(Auth::user()->id)) { ?> style="margin-top:52px;" <?php } ?>>
        <div class="container">
            <div class="box-header with-border">
                <h3 class="box-title">Privacy Policy</h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="main-sub-section-content">
                        <p>In our Privacy Policy, we will explain to you about the information which we will gather about you or any third parties affiliated by us. This privacy policy applies to our website, our mobile website as well. We would like to request you to read this Privacy Policy carefully in order to understand what {{ getSiteName() }} (“we”, “us”) do with your personal information. Any sort of use of our website by you or any dispute regarding it is subject to this Privacy Policy and stated Terms and Conditions of Use.</p>
                        <h4><b>How, When and What is collected?</b></h4>
                        <h4><b>How</b> it is collected?</h4>
                        <p>We always collect information directly from you, from third parties with your consent and automatically when you use or register to our services.</p>

                        <h4><b>When</b> is it collected?</h4>
                        <p>When you use our services or apply for them, when you send us queries or whether you choose to provide the information to us.</p>

                        <p>When you use our services or apply for them, when you send us queries or whether you choose to provide the information to us.</p>
                        <p>We receive information from banks, affiliates, credit reporting agencies and through referral programs when other customers of {{ getSiteName() }} give us your name and other data personal to you. We might combine this with other information that we collect about you.
                            Our Third party affiliates and us ({{ getSiteName() }}) automatically collect the following information about you:</p>
                        <ul class = 'pv_policy'>
                            <li>Domain name</li>
                            <li>Browser Type</li>
                            <li>OS</li>
                            <li>Web Pages you viewed</li>
                            <li>Your IP address</li>
                            <li>The amount of time you visited our website</li>
                            <li>The webpage or URL that led you to our website.</li>
                        </ul>

                        <h4><b>What</b> information does {{ getSiteName() }} collect?</h4>
                        <p>The information that we collect totally depends upon how you are interacting with our Website and our Services and as permitted by law.</p>
                        <ul class = 'pv_policy'>
                            <li>Your Email address, phone no., billing or mailing address.</li>
                            <li>Credit Card and bank account information.</li>
                            <li>IP address.</li>
                            <li>Identity validation</li>
                            <li>History related to your credit</li>
                            <li>Date of birth</li>
                            <li>Any transaction based data </li>
                            <li>Any or all information that you choose to provide us </li>
                            <li>Calls/Emails </li>
                            <li>Information from cookies and other tracking mechanism</li>
                        </ul>
                        <p>
                            You are responsible for providing us with accurate data related to you. Also if you want to take advantage of our “refer a friend” program then by applying for it you acknowledged automatically that you have your friend’s consent to provide us their personal information.
                        </p>
                        <h4><b>How</b> we use your information?</h4>
                        <ul class = 'pv_policy'>
                            <li>We use it to authenticate your identity.</li>
                            <li>To communicate with you, to provide our services, to tell you about any recent changes made to our Terms and Conditions which apply to you.</li>
                            <li>For providing you the information you demanded or to respond back to your inquiries if any and to provide customer support.</li>
                            <li>To offer customized solutions and help to you.</li>
                            <li>We may also use your personal information for promotional and advertising purposes.</li>
                            <li>We may use it for improving upon user experience of our website or for any other research and analytical purposes.</li>
                            <li>To guard our customers, employees or property from frauds or for any legal matter – for instance while investigating harassment, fraud or any other unlawful activity involving us or any of the companies with whom we do business, to enforce our privacy policy as well as our terms and conditions.   </li>
                        </ul>
                        <h4><b>When do we Share your information?</b></h4>
                        <p>We only share your information with our Third party affiliates including service providers, related financial institutions, entities and partners. If for any reason you would like us for us to not share your information for any marketing purposes, please contact us through our email or phone number. We will send you a link and all you have to do is to click on it to unsubscribe from any or all marketing emails being sent to you.</p>
                        <h4><b>Where do we store your data?</b></h4>
                        <p>Information you provide to us is stored on secured servers. Any transaction you perform is encrypted using SSL technology. Password access is required before you move further with the transaction which is why we recommend you not to share your password or related info with anybody.
                            Although, flow of information over the Internet is not totally secure, but we at {{ getSiteName() }} do our best to protect customer’s data to prevent any unauthorized access.</p>


                        <h4><b>Our use of Cookies</b></h4>
                        <p>Cookies are basically small text files constituting numbers and letters which when you visit a website, keeps track of your browsing preferences, recognizes devices or browser used by you.</p>
                        <p><b>Cookies are of several types:</b></p>
                        <ul class = 'pv_policy'>
                            <li><b>Session Cookies – </b>These cookie type are session based and they expire at the end of your browser session. Your preferences are noted for that particular session.</li>
                            <li><b>Persistent Cookies –</b> These cookies are stored on your device for multiple websites with your preferences in mind in between the browser sessions.</li>
                            <li><b>Third-Party Cookies-</b>These are set by third party website different from the website you are visiting.</li>
                            <li><b>First-Party Cookies –</b>These are set by the website you are visiting.</li>
                        </ul>
                        <p>
                            When you interact with or visit our website, services, applications, we or our authorized service providers might use cookies. Cookies will help in providing you with better experience as we store information pertaining to your ease of use and tailor make it to help you further in having a safe experience.
                        </p>
                        <p>
                            And yes, you can block cookies, but this might lead you in not being able to take advantage of certain website features and tools.
                        </p>
                        <h4><b>Changes to our privacy and cookie policy</b></h4>
                        <p>
                            We might update our Cookie policy from time to time. Any or all changes will be posted on our website or a notification will be sent through by an email. You can also check for the same in your “My Account” section on our website. You are requested to regularly check for any updates or changes made to the policy. Use of our services automatically means your acceptance of the current policy and updated policy from time to time.  You may also opt out of our marketing and promotions such that and it is made sure that we have your consent.
                        </p>
                        <h4><b>Updating your personal information</b></h4>
                        <p>
                            If you are a {{ getSiteName() }} customer and you would like to update your personal information with us, you just have to log into “My Account” section and change your personal information from there. If you are not a customer yet, you can email or call us. Also, for any privacy related concern, feel free to approach us. You can also contact us if you ever want to opt out of promotional emails and our other marketing content.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop