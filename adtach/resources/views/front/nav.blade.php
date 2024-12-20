@section('front.nav')
    <nav class="w-full h-[80px] flex justify-between place-items-center px-5 bg-[#1D4ED8]">
        {{-- <div class="w-[28%]">
            <img class="w-[100%]" src="{{ asset('storage/img/logo-2.png') }}" alt="">
        </div> --}}
        <div class="">
            <ul class="flex justify-center place-items-center gap-[1rem] ">
                <li class=""><a href="{{ route('viewHome') }}" class="text-white">Home</a></li>
                <li class=""><a href="{{ route('customerSalesTable') }}" class="text-white">Customer Sale Page</a></li>
                <li class=""><a href="{{ route('customerLeadTable') }}" class="text-white">Customer Lead Page</a></li>
                <li class=""><a href="{{ route('customerTrialTable') }}" class="text-white">Customer Trial Page</a></li>
                <li class=""><a href="{{ route('viewHelpTable') }}" class="text-white">Help </a></li>
                <li class=""><a href="{{ route('help')  }}" class="text-white">Help Request</a></li>
                <li class=""><a href="{{ route('viewCunstomerNumberTable') }}" class="text-white">Customer Calling Numbers</a></li>
            </ul>
        </div>
        <div class="flex place-items-center gap-6"> 
            <span class="font-bold text-white text-xl">{{ Auth::user()->name }} </span>
            <a href="{{ route('logout') }}" class="btn btn-light">Logout</a>
        </div>
    </nav>
    
@endsection