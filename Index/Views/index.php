<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>		
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Awesome Website</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
    </head>

    <body>
        <div id="container">
            <h1>Panda Test Application</h1>
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
                    <td>Controllers\Dummy</td>
                    <td>Index</td>
                    <td><?php echo $serviceLayer; ?></td>
                </tr>

                <tr>
                    <td>Model</td>
                    <td>Models\Dummy</td>
                    <td>Index</td>
                    <td><?php echo $model; ?></td>
                </tr>

                <tr>
                    <td>Library</td>
                    <td>Libraries\Dummy</td>
                    <td>Index</td>
                    <td><?php echo $library; ?></td>
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
                    <td><?php echo $modelShared; ?></td>
                </tr>                
                <tr>
                    <td>Library</td>
                    <td>Libraries\Share</td>
                    <td>Shared</td>
                    <td><?php echo $libraryShared; ?></td>
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

            h3{
                font-size:16px;
                line-height:21px;
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