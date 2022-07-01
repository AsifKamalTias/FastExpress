<footer>
    <div class="footer-bg p-5 text-white">
        <div class="container text-white d-flex justify-content-around">
           <div>
            <a href="{{route('about')}}">About</a>
            <a href="{{route('contact')}}">Contact</a>
            <a href="{{route('feedback')}}">Feedback</a>
           </div>
           <div>
            <a href="{{route('how-it-works')}}">How it works</a>
            <a href="{{route('faq')}}">FAQ</a>
            <a href="{{route('terms-and-conditions')}}">Terms & Conditions</a>
           </div>
           <div>
            <a href="https://www.facebook.com/" target="_blank">Facebook</a>
            <a href="https://www.instagram.com/" target="_blank">Instagram</a>
            <a href="https://www.youtube.com/" target="_blank">Youtube</a>
           </div>
        </div>   
        <div class="d-flex justify-content-center mt-5">
            <a class="btn btn-success">Join as Deliveryman</a>
        </div>
        <hr>
        <div class="d-flex justify-content-center text-white mt-3">
            <p>&copy; {{ now()->year }} FastExpress. All rights reserved.</p>
        </div>    
    </div>
</footer>