@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div id="data"> Record the cost of paper products including
                printing and writing paper, stationery, paper
                pads or notebooks, printer or copier paper,
                computer printout paper, examination paper,
                industrial use paper, bleached and unbleached
                paperboard, packaging papers packaging
                materials and packaging supplies, personal
                paper products (e.g. facial tissues, toilet seat
                covers, paper towels, toilet tissue, paper
                napkins and tablecloths) cardboard, laminated
                papers, coated papers, and newsprint and offset
                papers.
            </div>

        </div>

        <a href="{{ route('pdf.generate')}}"> <button> Download Pdf</button></a>


    </div>

@endsection

@push('scripts')
{{--    <script>--}}
{{--        function downloads() {--}}
{{--            $.ajax({--}}
{{--                type: "POST",--}}
{{--                url: '{{ route('pdf.generate')}}',--}}
{{--                data: {--}}
{{--                    '_token': '{{ csrf_token() }}',--}}
{{--                },--}}
{{--                dataType: 'json',--}}
{{--                success: function (data) {--}}
{{--                    console.log(data);--}}
{{--                },--}}
{{--                error: function (data) {--}}
{{--                    console.log(data);--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}

{{--    </script>--}}
@endpush
