<?php
  Route::get('gx-welcome-template', function () { /*OK*/
    return view('emails.gx.registration.welcome', [
      'logo' => setting('gx.logo'),
      'heading' => __('generic.mail.gx.welcome.heading', ['name' => 'John T']),
      'text' => 'your account created'
    ]);
  });
  Route::get('gx-registration-template', function () { /*OK*/
    return view('emails.gx.registration.registration_confirmation', [
      'logo' => setting('gx.logo'),
      'firstName' => 'Jolly',
      'heading' => __('generic.mail.gx.registration.heading'),
      'text' => 'your account created',
      'description1' => __('generic.mail.gx.registration.body_description_1'),
      'description2' => __('generic.mail.gx.registration.body_description_2'),
      'phrase' => __('generic.mail.gx.registration.phrase'),

    ]);
  });

  Route::get('hgp-registration-template', function () { /*OK*/
    return view('emails.registration.registration_confirmation', [
      'logo' => setting('site.logo'),
      'firstName' => 'first name will show here',
      'heading' => 'Welcome to HGP Company ',
      'text' => 'your account created',
      'description1' => __('generic.mail.hgp.registration.body_description_1'),
      'description2' => __('generic.mail.hgp.registration.body_description_2'),
    ]);
  });

  Route::get('gx-forgot-template', function () { /*OK*/
    return view('emails.gx.reset.reset_password', [
      'settings' => getGXSiteSettings(),
      'user' => \App\User::find(1),
      'userFullName' => 'John',
    ]);
  });

  Route::get('gx-abandoned-cart-template', function () { /*OK*/
    return view('emails.gx.abandoned.abandoned-cart', [
      'settings' => getGXSiteSettings(),
      'user' => \App\User::find(1),
      'userFullName' => 'John',
    ]);
  });

  Route::get('hgp-abandoned-cart-template', function () { /*OK*/
    return view('emails.abandoned.abandoned-cart', [
      'settings' => getSiteSettings(),
      'user' => \App\User::find(1),
      'userFullName' => 'John',
    ]);
  });

  Route::get('hgp-forgot-template', function () { /*OK*/
    return view('emails.reset.reset_password', [
      'settings' => getSiteSettings(),
      'user' => \App\User::find(1),
      'userFullName' => 'John',
    ]);
  });

  Route::get('gx-contact-us-template', function () {
    $query = (object)[
      'name' => 'Dotlogics',
      'email' => 'info@dotlogics.com',
      'message' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
    ];
    return view('emails.gx.contact.contact-us', [
      'query' => $query,
      'body' => __('generic.mail.gx.admin_contact.body'),
      'settings' => getGXSiteSettings(),
    ]);
  });

  Route::get('hgp-contact-us-template', function () {
    $query = (object)[
      'name' => 'Dotlogics',
      'email' => 'info@dotlogics.com',
      'message' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
    ];
    return view('emails.contact.contact-us', [
      'query' => $query,
      'body' => __('generic.mail.hgp.admin_contact.body'),
      'settings' => getSiteSettings(),
    ]);
  });

  Route::get('gx-thank-you-template', function () { /*OK*/
    $query = (object)[
      'name' => 'Dotlogics',
      'email' => 'info@dotlogics.com',
      'message' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
    ];


    return view('emails.gx.contact.thank-you', [
      'query' => $query,
      'body' => __('generic.mail.hgp.thankyou.body'),
      'provider' => 'gx',
      'settings' => getGXSiteSettings(),
    ]);
  });

  Route::get('hgp-thank-you-template', function () { /*OK*/
    $query = (object)[
      'name' => 'Dotlogics',
      'email' => 'info@dotlogics.com',
      'message' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.'
    ];


    return view('emails.contact.thank-you', [
      'query' => $query,
      'body' => __('generic.mail.hgp.thankyou.body'),
      'provider' => 'hgp',
      'settings' => getSiteSettings(),
    ]);
  });

  Route::get('gx-order-template/{id}', function ($id) {

    $order = \App\Order::with(["products.product","products.kit"])->find($id);
    // $order->load('products');
    return view('emails.gx.orders.new_order', [
      'order' => $order,
      'settings' => getGXSiteSettings(),
      'logo' => setting('gx.logo'),
    ]);
  });

  Route::get('hgp-order-template/{id}', function ($id) {

    $order = \App\Order::find($id);
    $order->load('products');
    return view('emails.orders.new_order', [
      'order' => $order,
      'settings' => getSiteSettings(),
      'logo' => setting('site.logo'),
    ]);
  });

Route::get('user-subscription', function () { /*OK*/
    return view('emails.gx.user-subscription', [
        'subscription' => (object) ['id' => '12345678'],
        'first_name' => "Tester",
    ]);
});

Route::get('assign-growmaster', function () { /*OK*/
    $growmasterFullName = "John Smith";
    $firstName = "John Smith";
    $company = setting('gx.company_name');
    return view('emails.gx.admin.growmaster_to_customer', [
        'heading' => __('generic.mail.gx.growmaster_assign.heading', ['name' => $company]),
        'body' => __('generic.mail.gx.growmaster_assign.body',['growmaster'=>$growmasterFullName]),
        'body2' => __('generic.mail.gx.growmaster_assign.body2',['growmaster'=>$growmasterFullName]),
        'firstName' => $firstName,
    ]);
});

Route::get('gx-admin-email', function () {

    return view('emails.orders.admin.gx.new_order', [
        'order' => [],
        'settings' => getGXSiteSettings(),
        'logo' => setting('gx.logo'),
    ]);
});

Route::get('hgp-admin-email', function () {

    return view('emails.orders.admin.new_order', [
        'order' => [],
        'settings' => getGXSiteSettings(),
        'logo' => setting('gx.logo'),
    ]);
});

Route::get('kit-purchase/{id}', function ($id) {

    $kit = \App\Kit::find($id);
    return view('emails.kit.purchase', [
        'first_name' => "John",
        'userKit' => $kit,
        'settings' => getGXSiteSettings(),
        'logo' => setting('gx.logo'),
    ]);
});
