@extends('master.app')

@section('title', $pageTitle . ' - Balai Air Tanah')

@section('content')
@include('pages.partials.menu_detail_hero', ['menuGroup' => $menuGroup, 'pageTitle' => $pageTitle])
@endsection
