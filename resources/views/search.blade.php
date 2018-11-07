<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Search</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"-->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 95vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .tick{
                content: "\2713";
                color: darkgreen;
             }
             .cross{
                content: "\2717";
                color: crimson;
             }
        </style>
    </head>
    <body>
        <div>
        {{ Form::open(array('action' => 'Search@index')) }}
            {{Form::text('query', $query)}}
            {{Form::submit('Search', ['class'=>'btn btn-primary'])}}
        {{ Form::close() }}
        </div>
        <div>
        Total results:    {{count($data->items)}}
        <table class="table-bordered">
            <thead>
                <th>Project Name</th>
                <th>Created at</th>
                <th>Time Since Creation</th>
                <th>Description</th>
                <th>Is a Fork</th> 
                <th>Stargazers</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($data->items as $item)
                <tr>
                    <td>
                        {{$item->full_name}} 
                    </td>
                    <td>
                        {{$item->created_at}}
                    </td>
                    <td>
                        @php
                            {{
                                $year = $month = $day = $hour = '';
                                $datetime1 = new DateTime(now());
                                $datetime2 = new DateTime($item->created_at);
                                $interval = $datetime1->diff($datetime2);
                                if($interval->y > 0){
                                    $year = $interval->y. ' year';
                                    $year .= ($interval->y >1)? 's':'';
                                }
                                if($interval->m > 0){
                                    $month = $interval->m. ' month';
                                    $month .= ($interval->m >1)? 's':'';
                                }
                                if($interval->d > 0){
                                    $day = $interval->d. ' day';
                                    $day .= ($interval->d >1)? 's':'';
                                }
                                if($interval->h > 0){
                                    $hour = $interval->h. ' hour';
                                    $hour .= ($interval->h >1)? 's':'';
                                }
                                echo "$year $month $day $hour";
                            }}
                        @endphp
                    </td>
                    <td>
                        @if (strlen($item->description) > 50)
                        {{substr($item->description, 0, 50)}}...
                        @else
                        {{$item->description}}
                        @endif
                    </td>
                    <td>
                       @if ($item->forks_count > 0)
                       <span class="tick">&#10003;</span>
                       @else
                       <span class="cross">&#10006</span>
                       @endif
                    </td>
                    <td>
                        {{$item->stargazers_count}}
                    </td>
                    <td>
                        <a href="{{$item->html_url}}" target="_blank">Action</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </body>
</html>