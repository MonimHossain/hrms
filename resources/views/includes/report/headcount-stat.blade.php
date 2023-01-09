@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endpush
<div class="kt-portlet kt-portlet--collapsed stat-container" data-ktportlet="true">
    <div class="row section-header">
        <div class="col-md-12 text-center">
            <h3>Employee head count stat</h3>
        </div>
    </div>  

    <div class="row">
        <div class="col-md-6"> 
            <div class="widget widget-black shadow">

                <div class="dates">
                    <div class="start">
                        <strong>Total Employee</strong> {{ $headcount_stat['allEmployee'] }}
                    </div>
                    <div class="ends">
                        <strong>Total Department</strong> {{ $headcount_stat['departments']->count() }}
                    </div>
                </div>                        

            </div>
        </div>        
        <div class="col-md-6">

            <div class="widget widget-black shadow">
                <div class="widget-title">Gender Ratio</div>

                <div>
                    <?php $count = 0; ?>
                    @foreach($headcount_stat['allEmployeeByGender'] as $gender)
                        <span class="{{ $count%2 == 0 ? 'pull-left':'pull-right' }}">
                            <h5 class="" style="color: #782B90;">{{ $gender->total . ' ' . $gender->gender }}</h5>
                        </span>
                        <?php $count++?>
                    @endforeach
                </div>
                <div style="clear: both;"></div>
                <div class="margin-top-10">
                    <?php $count = 0; ?>
                    @foreach($headcount_stat['allEmployeeByGender'] as $gender)
                        <div class="progress-bar progress-bar-success progress-bar-striped active {{ $count%2 == 0 ? '':'margin-top-10' }}" role="progressbar" style="width:{{ ($gender->total / $headcount_stat['allEmployee']) * 100 }}%">
                            <strong style="color: #fff;">{{ round(($gender->total / $headcount_stat['allEmployee']) * 100) }} % {{ $gender->gender }}</strong>
                        </div>
                        <?php $count++?>
                    @endforeach
                </div>
                <div class="widget-controls hidden">
                    <a href="#" class="widget-control-right"><span class="fa fa-times"></span></a>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-12 col-lg-12">
        <!--begin:: Widgets/Revenue Change-->
        <div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-widget14">
                <div class="kt-widget14__header">
                    <h3 class="kt-widget14__title">
                        Department wise headcount
                    </h3>
                </div>
                <div class="cart-wrapper">

                    <ul class="chart">
                        @foreach($headcount_stat['employeeByDepartment'] as $depatment=>$count)
                            <li>
                                <span style="height:{{ $count }}%" title="{{ $depatment }}" class="businessName"><a href="">{{ $count }}</a></span>
                            </li>
                        @endforeach
                    </ul>  
                </div>
            </div>
            <!--end:: Widgets/Revenue Change-->
        </div>            
    </div>    

    <div class="row">        
        <div class="col-md-6">
            <table class="stat-card">
                <tr>
                    <td class="card-header text-center" colspan="2">
                        New joining
                    </td>
                </tr>
                <?php 
                    $totalJoining = 0;
                    foreach($headcount_stat['newJoinerByDepartment'] as $dept_name => $count){
                        $totalJoining += $count;
                    }   
                ?> 
                <tr class="card-row">
                    <td rowspan="2" class="card-col">
                        <h4>Total {{ $totalJoining }}</h4>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="stat-card">
                <tr>
                    <td class="card-header text-center" colspan="2">
                        Total closing
                    </td>
                </tr>
                <?php 
                    $totalClosing = 0;
                    foreach($headcount_stat['closingByDepartment'] as $dept_name => $count){
                        $totalClosing += $count;
                    }   
                ?> 
                <tr class="card-row">
                    <td rowspan="2" class="card-col">
                        <h4>Total {{ $totalClosing }}</h4>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row margin-top-15">
        <div class="col-xl-6 col-lg-6 order-lg-6 order-xl-1 padding-10">
            <div class="kt-portlet kt-portlet--height-fluid padding-20">
                <h3 class="stat-table-header">
                    Department wise joining
                </h3>
                <table class="table table-bordered margin-top-15">
                    <tr>
                        <th>Department</th>
                        <th>Count</th>
                        <th>Joing rate</th>
                    </tr>                             
                    @foreach($headcount_stat['newJoinerByDepartment'] as $dept_name => $count)
                        @if( $count > 0 )
                            <tr>
                                <td>{{ $dept_name }}</td>
                                <td>{{ $count }}</td>
                                <td>                                
                                    <div class="progress h-18-f-12">
                                        <div class="progress-bar" role="progressbar" style="width: {{ ($count / $totalJoining) * 100 }}%" aria-valuenow="{{ ($count / $totalJoining) * 100 }}" aria-valuemin="0" aria-valuemax="100">{{ ($count / $totalJoining) * 100 }}%</div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if($totalJoining == 0)
                        <tr>
                            <td colspan="3" class="text-center">No joining</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 order-lg-6 order-xl-1 padding-10">
            <div class="kt-portlet kt-portlet--height-fluid padding-20">
                <h3 class="stat-table-header">
                    Department wise closing
                </h3>
                <table class="table table-bordered margin-top-15">
                    <tr>
                        <th>Department</th>
                        <th>Count</th>
                        <th>Closing rate</th>
                    </tr>                             
                    @foreach($headcount_stat['closingByDepartment'] as $dept_name => $count)
                        @if( $count > 0 )
                            <tr>
                                <td>{{ $dept_name }}</td>
                                <td>{{ $count }}</td>
                                <td>                                
                                    <div class="progress h-18-f-12">
                                        <div class="progress-bar" role="progressbar" style="width: {{ ($count / $totalClosing) * 100 }}%" aria-valuenow="{{ ($count / $totalClosing) * 100 }}" aria-valuemin="0" aria-valuemax="100">{{ ($count / $totalClosing) * 100 }}%</div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @if($totalClosing == 0)
                        <tr>
                            <td colspan="3" class="text-center">No closing</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>                
        <div class="col-xl-12 col-lg-12 order-lg-12 order-xl-1 hidden">
            <!--begin:: Widgets/Revenue Change-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-widget14">
                    <div class="kt-widget14__header">
                        <h3 class="kt-widget14__title">
                            Department wise closing
                        </h3>
                    </div>
                    <div class="kt-widget14__chart" style="height:120px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="employeeClosingStat" style="display: block; width: 282px; height: 200px;" width="282" height="200" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
                <!--end:: Widgets/Revenue Change-->
            </div>
        </div>
    </div>
</div>