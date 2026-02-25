@extends('master.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
    <section>
        <div class="panel full-card">
            <h3 style="margin:0;font-size:40px;line-height:1.15;">Dashboard</h3>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>AI Task</th>
                        <th>Date</th>
                        <th>Accuracy</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Chat Analysis</td>
                        <td>12 Dec, 2025</td>
                        <td>97%</td>
                        <td>1.8m</td>
                        <td class="status good">Success</td>
                    </tr>
                    <tr>
                        <td>Fraud Detection</td>
                        <td>13 Dec, 2025</td>
                        <td>86%</td>
                        <td>1.2m</td>
                        <td class="status warn">Warning</td>
                    </tr>
                    <tr>
                        <td>Data Processing</td>
                        <td>14 Dec, 2025</td>
                        <td>74%</td>
                        <td>2.8s</td>
                        <td class="status bad">Failed</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
