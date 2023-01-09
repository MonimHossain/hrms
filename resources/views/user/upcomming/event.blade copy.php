    <!-- start -->
    <div class="row">
        @foreach($calendarDataset as $key=> $data)
        <div class="col-md-3">
            <div class="calendar">
                <a href="#" class="event clearfix">
                    <div class="event_icon">
                        <div class="event_month">{{ \Carbon\Carbon::parse($data->event_date)->format('M') }}</div>
                    <div class="event_day">{{ \Carbon\Carbon::parse($data->event_date)->format('d') }}</div>
                    </div>
                <div class="event_title">{{ $data->title }}</div>
                </a>
                <div class="event clearfix">
                        <div class="event_title"><span><b>Details : </b></span>{{ $data->content }}</div>
                </div>
                <div class="event clearfix">
                    <div class="event_title">
                        <span><b>Lication : </b></span>
                        Khilkhet Nikunja, NNT
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- end -->
