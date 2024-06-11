@extends('layouts.master')

@section('content')
<main class="h-full pb-16 overflow-y-auto">
    <div class="lg:lg:container px-4 lg:px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700">{{ $page_title }}</h2>
            <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-secondary bg-project rounded-lg shadow-md focus:outline-none focus:shadow-outline-project">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 fill-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M336 64h-80a64 64 0 0 1 64 64H64a64 64 0 0 1 64-64H48a48 48 0 0 0-48 48v352a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V112a48 48 0 0 0-48-48zm-23 208L170 414a12 12 0 0 1-17 0l-82-84a12 12 0 0 1 0-17l28-28a12 12 0 0 1 17 0l46 47 106-106a12 12 0 0 1 17 0l28 29a12 12 0 0 1 0 17z" style="opacity:.4"/><path d="M285 226a12 12 0 0 0-17 0L162 332l-46-47a12 12 0 0 0-17 0l-28 28a12 12 0 0 0 0 17l82 83a12 12 0 0 0 17 1l143-142a12 12 0 0 0 0-17zM256 64a64 64 0 0 0-128 0 64 64 0 0 0-64 64h256a64 64 0 0 0-64-64zm-64 24a24 24 0 1 1 24-24 24 24 0 0 1-24 24z"/></svg>
                    <span>{{ $page_title }}</span>
                </div>
            </div>
            <div class="alert bg-teal-100 border-l-4 border-teal-500 rounded-lg text-teal-900 px-4 py-3 mb-8 hidden">
                <div class="flex items-center">
                    <div class="py-1"><svg fill="#14b8a6" class="fh-6 w-6 text-teal-500 mr-4 fill-teal-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 8a248 248 0 1 0 0 496 248 248 0 0 0 0-496zm0 48a200 200 0 1 1 0 400 200 200 0 0 1 0-400m140 130-22-22c-5-5-13-5-17-1L215 304l-59-61c-5-4-13-4-17 0l-23 23c-5 5-5 12 0 17l91 91c4 5 12 5 17 0l172-171c5-4 5-12 0-17z"></path></svg></div>
                    <div>
                        <p class="text-sm">Arquivo gerado com sucesso.</p>
                    </div>
                </div>
            </div>
            @include('../messages/message')
            <form method="get">
                @include('logs._filter')
            </form>
            <div class="w-full overflow-hidden rounded-lg shadow-sm mb-8">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                            <th class="px-4 py-3">Usuário</th>
                            <th class="px-4 py-3">Ação</th>
                            <th class="px-4 py-3">DESCRIÇÃO</th>
                            <th class="px-4 py-3 text-center">DATA E HORA</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            
                            @if(count($datas) < 1)
                                <tr class="w-full">
                                    <td colspan="4" class="border text-center text-gray-500 font-semibold p-4">Não existe {{ strtolower($page_title) }} cadastrado</td>
                                </tr>
                            @else
                                @foreach ($datas as $index => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm">
                                            <div class="flex flex-col text-sm font-semibold">
                                                {{ $item->user_name }}
                                                <span class=" font-normal">{{$item->user_email}}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">{{ $item->action }}</td>
                                        <td class="px-4 py-3 text-sm">{{ $item->message }}</td>
                                        <td class="px-4 py-3 text-sm text-center">{{$item->created_at->format('d/m/Y H:i:s')}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                {!! $datas->onEachSide(1)->links('pagination::tailwind') !!}
            </div>
        </div>
    </main>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <style>
        [data-te-input-notch-leading-ref],
        [data-te-input-notch-middle-ref],
        [data-te-input-notch-trailing-ref] {
            border: 0 !important;
        }
    </style>
@endsection

@section('scripts_footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/lagden/vanilla-masker@lagden/build/vanilla-masker.min.js"></script>

    <script>
        (() => {
            'use strict'
            const exportar = document.querySelector('.exportar')
            exportar.addEventListener('click', event => {
                event.preventDefault()

                var spinning = document.querySelector(".spinning")
                var alert = document.querySelector('.alert')
                
                spinning.style.display = 'block'
                exportar.classList.add('disabled:opacity-50','disabled:hover:bg-[#02497f]')
                exportar.disabled = true

                fetch("{{ route('web.logs.export') }}?search={{ Request::get('search') }}&type={{Request::get('type')}}&initial_date={{ Request::get('initial_date') }}&end_date={{ Request::get('end_date') }}", {
                    method: 'GET'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText)
                    }
                    return response.blob()
                })
                .then(data => {

                    var search = document.querySelector('.search')
                    search = search.value
                    search = search ? `-${search}` : ''

                    var di = document.querySelector('.di')
                    di = di.value
                    di = di ? `-${di}` : ''
                    
                    var df = document.querySelector('.df')
                    var df = df.value
                    df = df ? `-${df}` : ''
                
                    alert.style.display = 'block'
                    setTimeout(() => {
                        alert.style.display = 'none'
                    }, 5000);

                    spinning.style.display = 'none'
                    exportar.classList.remove('disabled:opacity-50','disabled:hover:bg-yellow-400')
                    exportar.disabled = false

                    var url = window.URL.createObjectURL(data)
                    var anchor = document.createElement("a")
                    anchor.href = url
                    anchor.download = `Logs${search.toLowerCase()}${di}${df}`
                    anchor.click()

                    window.URL.revokeObjectURL(url)
                })
            }, false)
        })()

		VMasker(document.querySelectorAll(".data")).maskPattern('99/99/9999');

        document.querySelectorAll(".datepicker").forEach(item => {
            new te.Datepicker(item, {
                title: "Selecione",
                monthsFull: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro",],
                monthsShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez",],
                weekdaysFull: ["Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag",],
                weekdaysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
                weekdaysNarrow: ["D", "S", "T", "Q", "Q", "S", "S"],
                okBtnText: "Ok",
                clearBtnText: "Limpar",
                cancelBtnText: "Cancelar",
            });
        });
    </script>
@endsection