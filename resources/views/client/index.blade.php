<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KY</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="font-sans antialiased bg-slate-800">
    <div class="flex flex-col justify-center text-gray-50">
        <!-- Header -->
        <div class="container max-w-screen-xl flex justify-start w-full mx-auto mt-2 py-2">
            <!-- Logo -->
            <a href="#" class="mr-6"><img src="{{ asset('storage/logo_pc.png') }}" alt="Logo"></a>
            <!-- Nav -->
            <ul class="flex items-center flex-row w-full gap-9">
                <li class="text-center align-middle">
                    <a href="#" class="flex flex-col hover:text-amber-300 hover:font-bold"><span class="text-orange-500">首页</span><span>HOME</span></a>
                </li>
                <li class="text-center align-middle">
                    <a href="#" class="flex flex-col hover:text-amber-300 hover:font-bold"><span class="text-orange-500">注册会员</span><span>CASINO</span></a>
                </li>
                <li class="text-center align-middle">
                    <a href="#" class="flex flex-col hover:text-amber-300 hover:font-bold"><span class="text-orange-500">优惠活动</span><span>SLOTS</span></a>
                </li>
                <li class="text-center align-middle">
                    <a href="#" class="flex flex-col hover:text-amber-300 hover:font-bold"><span class="text-orange-500">在线客服</span><span>SPORTS</span></a>
                </li>
            </ul>
            <!-- Button -->
            <div class="justify-end mr-3 flex">
                <button class="w-40 my-1 text-center rounded-full border-none bg-gradient-to-r from-orange-500 to-amber-200 hover:from-pink-500 hover:to-yellow-500">
                    <span class="font-semibold text-white">申请进度查询</span>
                    <span class="text-xs text-cyan-900 font-medium">PROGRESS QUERY</span>
                </button>
            </div>
        </div>
        <!-- End Header -->
        <!-- Banner -->
        <div class="swiper w-full mt-2">
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide w-full bg-slate-200"><img src="{{ asset('storage/banner.png') }}" alt="Banner"></div>
                <div class="swiper-slide w-full bg-slate-200"><img src="{{ asset('storage/banner.png') }}" alt="Banner"></div>
                <div class="swiper-slide w-full bg-slate-200"><img src="{{ asset('storage/banner.png') }}" alt="Banner"></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <!-- Content -->
        <div class="container mx-auto px-4 max-w-screen-xl mt-3 mb-12">
            <!-- Notification -->
            <div class="h-10 flex flex-row bg-slate-700 rounded-md overflow-hidden">
                <div class="my-auto flex flex-row flex-none mr-2">
                    <img src="{{ asset('storage/gg.png') }}" alt="Notification" class="h-max my-auto align-middle px-2">
                    <span class="whitespace-nowrap text-gray-300">最新公告</span>
                </div>
                <p class="my-auto mx-auto">温馨提示：请点击对应活动类别申请，提交申请后专员将于2小时内审核办理，提交申请后可以点击审核进度查询</p>
            </div>
            <!-- Activity -->
            <div class="grid grid-cols-3 gap-x-5 gap-y-8 mt-8">
                @foreach([1, 2, 3, 4, 5] as $item)
                <div class="flex flex-col rounded-lg shadow-md shadow-cyan-600 cursor-pointer hover:animate-bounce-slow">
                    <div class="w-full h-full items-center">
                        <img src="{{ asset('activity/activity_2.jpg') }}" alt="Activity 1" class="m-auto rounded-t-lg w-full h-full">
                    </div>
                    <div class="py-2 pl-5">棋牌NO.3-好运连连，连赢得大奖</div>
                </div>
                <div class="flex flex-col rounded-lg shadow-md shadow-cyan-600 cursor-pointer hover:animate-bounce-slow">
                    <div class="w-full h-full items-center">
                        <img src="{{ asset('activity/activity_3.png') }}" alt="Activity 1" class="m-auto rounded-t-lg w-full h-full">
                    </div>
                    <div class="py-2 pl-5">棋牌NO.3-好运连连，连赢得大奖</div>
                </div>
                <div class="flex flex-col rounded-lg shadow-md shadow-cyan-600 cursor-pointer hover:animate-bounce-slow">
                    <div class="w-full h-full items-center">
                        <img src="{{ asset('activity/activity_4.png') }}" alt="Activity 1" class="m-auto rounded-t-lg w-full h-full">
                    </div>
                    <div class="py-2 pl-5">棋牌NO.3-好运连连，连赢得大奖</div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Footer -->
        <div class="w-full flex flex-col justify-center mx-auto border-t-2 border-cyan-900">
            <div class="py-8 items-center">
                <img src="{{ asset('storage/partner.png') }}" alt="Partner" class="mx-auto">
            </div>
            <div class="py-4 items-center flex flex-col justify-center">
                <img src="{{ asset('storage/logo_pc.png') }}" alt="Logo" class="mx-auto scale-90">
                <p class="max-w-4xl text-center text-xs text-zinc-400 my-5">通过进入、继续使用或浏览此网站，您即被认定接受：我们将使用特定的浏览器cookies优化您的客户享用体验。威尼斯人仅会使用优化您服务体验的cookies，而不是可侵犯您隐私的cookies。关于我们使用cookies，以及您如何取消、管理cookies使用的更多详情，请参考我们的Cookies政策。</p>
                <ul class="text-center py-7">
                    <li class="inline-block border-r-2 border-stone-400 pr-4 mr-4"><a href="#" class="text-sm">关于我们</a></li>
                    <li class="inline-block border-r-2 border-stone-400 pr-4 mr-4"><a href="#" class="text-sm">存款帮助</a></li>
                    <li class="inline-block border-r-2 border-stone-400 pr-4 mr-4"><a href="#" class="text-sm">取款帮助</a></li>
                    <li class="inline-block border-r-2 border-stone-400 pr-4 mr-4"><a href="#" class="text-sm">常见问题</a></li>
                </ul>
            </div>
        </div>
        <!-- Floating -->
        <div class="fixed top-1/2 right-0 -translate-y-1/2 z-10">
            <ul class="grid grid-cols-1">
                <li id="topBtn" class="px-3 pt-4 text-center relative hover:animate-bounce-in"><img src="{{ asset('storage/gotop.png') }}" alt="Top" class="w-14 h-14"></li>
                <li id="kefuBtn" class="px-3 pt-4 text-center relative hover:animate-bounce-in"><img src="{{ asset('storage/kefu.png') }}" alt="Top" class="w-14 h-14"></li>
                <li id="downloadBtn" class="px-3 pt-4 text-center relative hover:animate-bounce-in"><img src="{{ asset('storage/download.png') }}" alt="Top" class="w-14 h-14"></li>
            </ul>
        </div>
    </div>
</body>
</html>
