@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet" />

@endpush
@section('content')

<body class="d-flex justify-content-center align-items-center bg-light">
	<div class="card p-3 shadow" style="max-width: 100%;">
		<h2 class="text-center p-3">Dermal Conference</h2>
		<nav>
			<div class="nav nav-tabs justify-content-evenly mb-3" id="nav-tab" role="tablist">
				<a href="#abstract"><button class="nav-link active" id="abstracts" data-coreui-toggle="tab" data-coreui-target="#abstract" type="button" role="tab" aria-controls="abstract" aria-selected="true">Abstract Submission</button></a>
				<a href="#research"><button class="nav-link" id="researchs" data-coreui-toggle="tab" data-coreui-target="#research" type="button" role="tab" aria-controls="research" aria-selected="false">Research Publication</button></a>
				<a href="#subscription"><button class="nav-link" id="subscriptions" data-coreui-toggle="tab" data-coreui-target="#subscription" type="button" role="tab" aria-controls="subscription" aria-selected="false">Subscription</button></a>
			</div>
		</nav>
		<div class="tab-content p-3 border bg-light" id="nav-tab">
			<div class="tab-pane fade show active" id="abstract" role="tabpanel" aria-labelledby="abstracts">
				<p>Abstract Submission.</p>
			</div>
			<div class="tab-pane fade" id="research" role="tabpanel" aria-labelledby="researchs">
				<p>Research Publication.</p>
			</div>
			<div class="tab-pane fade" id="subscription" role="tabpanel" aria-labelledby="subscriptions">
				<p>Subscription.</p>
			</div>
		</div>
	</div>
</body>




@endsection
