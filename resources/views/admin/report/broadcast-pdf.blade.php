

<html>
<head>
    <style>
        /**
               Set the margins of the page to 0, so the footer and the header
               can be of the full height and width !
            **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }
    </style>

</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header>
       
        <p>Header</p>
    </header>

    <footer>
       <p>Footer</p>
       
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
         <div class="kt-section__content">   
            <h4>Account Completion Report :</h4>                                 
                <table class="table" style="width: 100%; border-collapse: collapse;" border="0">                                                                     
                    @foreach ($accountCompletionReport as $data)
                        <tr>
                            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">
                                <div class="progress">
                                    <div class="progress-bar " role="progressbar" aria-valuenow="{{ $data->profile_completion }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $data->profile_completion }}%">{{ $data->profile_completion }}%</div>
                                </div>
                            </td>
                            <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">
                                {{ $data->completed }}
                            </td>
                        </tr>        
                    @endforeach
                </table>
                <br>
                <br>
                <h4>Attrition Report :</h4>
                <table style="width: 100%; border-collapse: collapse;" border="0">
                <thead>
                <tr>
                    <th style="padding: 5px;border: 1px solid black;border-collapse: collapse;">Process Name</th>
                    <th style="padding: 5px;border: 1px solid black;border-collapse: collapse;">Resign</th>
                    <th style="padding: 5px;border: 1px solid black;border-collapse: collapse;">Termination</th>
                    <th style="padding: 5px;border: 1px solid black;border-collapse: collapse;">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_final_closing = 0;
                $total_termination_status = 0;
                $grand_total = 0;
                ?>
                @foreach($attritionReport as $row)
                    <tr>
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $row->name ?? 'Other' }}</td>
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{!! $row->final_closing ?? '' ; !!}</td>
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $row->termination_status ?? '' }}</td>
                        <td style="padding: 5px;border: 1px solid black;border-collapse: collapse;">{{ $row->total ?? '' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>
            <br>
            <h4>Missing Salary Setting : {{ $missingReport->count }}</h4>
            <br>
            <br>
            <h4>Untract Employee List : {{ $untrackEmployee->count }}</h4>
         </div> 
    </main>

</body>
</html>


