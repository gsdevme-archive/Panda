<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- We use a special global function within Views (ifsetor()) -->
        <meta charset="<?php echo ifsetor($charset, 'utf-8'); ?>"/>		
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php echo ifsetor($title, 'Title'); ?></title>
        <meta name="keywords" content="<?php echo (isset($keywords)) ? $keywords : 'keywords'; ?>">
        <meta name="description" content="<?php echo (isset($description)) ? $description : 'description'; ?>">
    </head>

    <body>
        <div id="container">
            <h1><a href="/">Panda Test Application</a></h1>
            <hr/>

            <table>
                <tr>
                    <th>Type</th>
                    <th>Class</th>
                    <th>Application</th>
                    <th>Response</th>
                </tr>

                <tr>
                    <td>Service Layer</td>
                    <td>ServiceLayers\Dummy</td>
                    <td>Index</td>
                    <td><?php echo ifsetor($serviceLayer, '<b>Failed, no response</b>'); ?></td>
                </tr>

                <tr>
                    <td>Model</td>
                    <td>Models\Dummy</td>
                    <td>Index</td>
                    <td><?php echo ifsetor($model, '<b>Failed, no response</b>'); ?></td>
                </tr>

                <tr>
                    <td>Model - DB Test</td>
                    <td>Models\Dummy</td>
                    <td>Index</td>
                    <td><?php echo ifsetor($dbTest, '<b>Failed, no response or you have no Test Database</b>'); ?></td>
                </tr>

                <tr>
                    <td>Model - Session Test</td>
                    <td>Models\Dummy</td>
                    <td>Index</td>
                    <td><?php echo ifsetor($sessionTest, '<b>Failed, hmm we failed to create a session</b>'); ?></td>
                </tr>

                <tr>
                    <td>Library</td>
                    <td>Libraries\Dummy</td>
                    <td>Index</td>
                    <td><?php echo ifsetor($library, '<b>Failed, no response</b>'); ?></td>
                </tr>

                <tr>
                    <td>Helper</td>
                    <td>Helpers\Dummy</td>
                    <td>Index</td>
                    <td><?php echo $this->helper('Dummy')->doSomething(); ?></td>
                </tr>

            </table>

            <table>
                <tr>
                    <th>Type</th>
                    <th>Class</th>
                    <th>Application</th>
                    <th>Response</th>
                </tr>                
                
                <tr>
                    <td>Model</td>
                    <td>Models\Share</td>
                    <td>Shared</td>
                    <td><?php echo ifsetor($modelShared, '<b>Failed, no response</b>'); ?></td>
                </tr>                
                <tr>
                    <td>Library</td>
                    <td>Libraries\Share</td>
                    <td>Shared</td>
                    <td><?php echo ifsetor($libraryShared, '<b>Failed, no response</b>'); ?></td>
                </tr>                
            </table>
        </div>


        <style>
            body{
                text-align:center;
                margin:0;
                padding:0;
                font-family: sans-serif;
                background:#FAFAFA;
            }

            #container{
                width:960px;
                margin:0 auto;
                padding:10px;
                text-align:left;
                background:#FFF;
            }

            h1 a{
                font-size:32px;
                line-height:36px;
                color:#000;
                text-decoration: none;
            }

            table{
                width:100%;
                margin:0 0 5px 0;
                border-bottom:1px solid #dedede;
                padding:0 0 5px 0;
            }

            table tr th{
                font-size:16px;
                line-height:32px;
                border-bottom:1px solid #dedede;
                text-indent: 5px;
            }

            table tr td{
                font-size:13px;
                line-height:26px;
                margin:0;
                text-indent: 5px;
            }

            table tr td:nth-child(3n), table tr td:nth-child(1n){
                width:15%;
            }

            table tr td:nth-child(4n){
                width:60%;
                font-style:italic;
            }

            table tr:nth-child(even){
                background:#FAFAFA;
            }
        </style>        
    </body>
</html>