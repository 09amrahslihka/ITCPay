<footer class = 'footer'>
    <div class="container">
        <div class="col-sm-4 text-left">
            <ul>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/faqs')}}"><i class="fa fa-question-circle" aria-hidden="true"></i>FAQs</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/Support')}}"><i class="fa fa-user-plus" aria-hidden="true"></i>Support</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/feedbacks')}}"><i class="fa fa fa-table" aria-hidden="true"></i>Feedbacks</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/legal-agreements')}}"><i class="fa fa-file-text" aria-hidden="true"></i>Legal Agreements</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/fraud-prevention')}}"><i class="fa fa-ban" aria-hidden="true"></i>Fraud Prevention</a></li>
            </ul>
        </div>

        <div class="col-sm-4 text-left">
            <ul>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/fees')}}"><i class="fa fa-dollar" aria-hidden="true"></i>&nbsp;&nbsp;Fees</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/cookie-policy')}}"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;Cookie Policy</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/Terms-of-Service')}}"><i class="fa fa-tags" aria-hidden="true"></i>Terms of Service</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/trademark-and-copyright-policy')}}"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp;&nbsp;Trademark & Copyright Policy</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/developers')}}"><i class="fa fa-file-code-o" aria-hidden="true"></i>&nbsp;Developers</a></li>
            </ul>
        </div>

        <div class="col-sm-4 text-left">
            <ul>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/aboutus')}}"><i class="fa fa-user" aria-hidden="true"></i>About Us</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/privacy-policy')}}"><i class="fa fa-key" aria-hidden="true"></i>Privacy Policy</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/avoiding-chargebacks')}}"><i class="fa fa-exchange" aria-hidden="true"></i>Avoiding Chargebacks</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/avoiding-phishing-emails')}}"><i class="fa fa-envelope" aria-hidden="true"></i>Avoiding Phishing Emails</a></li>
                <li style="margin-bottom:5px;"><a href="{{URL::to('/pages/our-services')}}"><i class="fa fa-tasks" aria-hidden="true"></i>Our Services</a></li>
            </ul>
        </div>

        <div class="col-sm-12 text-center footer-link-copyright" style="margin-top:20px;">
            <p class="copy_right">Copyright &copy; <?php echo date("Y"); ?> {{ getSiteName() }}. All rights reserved.</p>
        </div>
    </div>
</footer>
