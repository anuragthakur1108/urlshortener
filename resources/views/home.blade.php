@extends('layouts.app')

@section('content')
@if (\Session::has('success'))
<div class="alert alert-success">
    <ul>
        <li>{!! \Session::get('success') !!}</li>
    </ul>
</div>
@endif
@if (\Session::has('error'))
<div class="alert alert-error">
    <ul>
        <li>{!! \Session::get('error') !!}</li>
    </ul>
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Make your web url's short</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="/home/saveData" method="post">  
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="web_url" class="col-md-4 control-label">Enter Url:</label>
                            <div class="col-md-6">
                                <input id="web_url" type="text" class="form-control" name="web_url" value="" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>  
                </div>
            </div>
            <?php
            if (isset($previous_urls) && !empty($previous_urls)) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">Previous Url's</div>
                    <div class="panel-body"> 
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>S.NO</th>
                                    <th>Url</th>
                                    <th>Shortend Url</th>
                                    <th>View Count</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach ($previous_urls as $urls) {
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $urls->web_url; ?></td>
                                        <td><?php echo url('/') . "/" . $urls->shorten_url; ?></td>
                                        <td><?php echo $urls->view_count; ?></td>
                                        <td><a href="/home/delete_url?url_id=<?php echo $urls->url_id; ?>" >Delete</a></td>
                                    </tr>
                                    <?php
                                    $count++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>
@endsection
