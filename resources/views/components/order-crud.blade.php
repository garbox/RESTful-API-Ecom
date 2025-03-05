<h5 data-toggle="collapse" href="#orderMain" role="button" aria-expanded="false" aria-controls="orderMain" style="cursor: pointer;">Order</h5>
<ul class="collapse" id="orderMain">
    
    <!-- GET /order/{order} -->
    <li>
        <span data-toggle="collapse" href="#adminOrderShow" role="button" aria-expanded="false" aria-controls="adminOrderShow" style="cursor: pointer;">
            GET api/order/{order_id}
            </span>

            <div class="collapse codeAera" id="adminOrderShow" >
                <code> 
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER-API-KEY": string<br>
                }<br>
                <hr>
                <p>RESPONSE:<br>json</p>
                {<br>
                'id' : integer,<br>
                'user_id' : integer,<br>
                'stripe_payment_id' : string,<br>
                'total_price' : integer<br>
                }
                </code>
            </div>
    </li>

    <!-- POST /order -->
     <!-- Needs shipping info, and must be placed by a user -->
    <li>
        <span data-toggle="collapse" href="#orderStore" role="button" aria-expanded="false" aria-controls="orderStore" style="cursor: pointer;">
            POST {{parse_url(route('order.create'),PHP_URL_PATH)}}
            </span>

            <div class="collapse codeAera" id="orderStore" >
                <code> 
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER-API-KEY": string<br>
                }<br>
                body: {<br>
                'shipping_name' : string,<br>
                'shipping_email' : string,<br>
                'shipping_phone' : string,<br>
                'shipping_address' : string,<br>
                'shipping_city' : string,<br>
                'shipping_state' : string,<br>
                'shipping_zip' : string,<br>
                }
                <hr>
                <p>RESPONSE:<br>json</p>
                {<br>
                'id' : integer,<br>
                'user_id' : integer,<br>
                'stripe_payment_id' : string,<br>
                'total_price' : integer<br>
                }
                </code>
            </div>
    </li>

    <!-- PUT /order/{order_id} -->
    <li>
        <span data-toggle="collapse" href="#orderUpdate" role="button" aria-expanded="false" aria-controls="orderUpdate" style="cursor: pointer;">
            PUT api/order/
            </span>
            <div class="collapse codeAera" id="orderUpdate" >
                <code> 
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER-API-KEY": string<br>
                }<br>
                body: {<br>
                    'order_id' : integer,<br>
                    'stripe_payment_intent_id' : integer<br>
                }
                <hr>
                <p>RESPONSE:<br>json</p>
                {<br>
                    'id' : integer<br>
                    'user_id' : integer<br>
                    'total_price' : integer<br>
                    'stripe_payment_intent_id' : string <br>
                }
                </code>
            </div>
    </li>

    <!-- DELETE /order/{order_id}-->
    <li>
        <span data-toggle="collapse" href="#orderDelete" role="button" aria-expanded="false" aria-controls="orderDelete" style="cursor: pointer;">
            DELETE api/order/{order_id}
            </span>

            <div class="collapse codeAera" id="orderDelete" >
                <code> 
                <p>REQUEST:<br>json</p>
                headers: {<br>
                "GLOBAL-API-KEY" : string,<br>
                "USER-API-KEY": string<br>
                }
                <hr>
                <p>RESPONSE:<br>json</p>
                {<br>
                    'message' : 'Order deleted successfully.'<br>
                }
                </code>
            </div>
    </li>
        </li>

</ul>