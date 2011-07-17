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
            <h3>Loaded Within the View</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

            <p>Extra Information Sent: <b><?php echo $test; ?></b></p>
            
            <p>Extra Information Sent As an Array: <b><?php echo $foobar; ?></b></p>
            
            <?php $this->element('dummyElement'); ?>            
            
            <h3>Data passed from the Controller</h3>
            <?php if (isset($list)): ?>
                    <?php foreach ($list as $item): ?>
                        <li><?php echo $item; ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
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
            
            p,li{
                font-size:13px;
                line-height:16px;
            }
            
            li{
                list-style-position: inside;
                margin:0 10px;
            }
            
            h3{
                font-size:16px;
                line-height:21px;
            }
        </style>        
    </body>
</html>