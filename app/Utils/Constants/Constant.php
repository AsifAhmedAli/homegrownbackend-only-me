<?php
  
  
  namespace App\Utils\Constants;
  
  
  class Constant
  {
    const HGP                    = 'hgp';
    const GX                     = 'gx';
    const BLOG_LISTING_PAGE_SLUG = 'blog-listing';
    const SHOW_ON_HGP_PROJECT    = 'show_on_hgp_project';
    const SHOW_ON_GX_PROJECT     = 'show_on_gx_project';
    const ACTIVE                 = 1;
    const IN_ACTIVE              = 1;
    
    const DEFAULT_COUNTRY = 'USA';
    
    const OPEN = 'open';
    const IN_PROGRESS = 'in progress';
    const ON_HOLD = 'on hold';
    const CLOSED = 'closed';
  
    public const Mimes = [
      'application/pdf' => [
        'extension' => 'pdf',
        'type' => 'pdf'
      ],
      'application/zip' => [
        'extension' => 'zip',
        'type' => 'zip'
      ],
      'application/octet-stream' => [
        'extension' => 'zip',
        'type' => 'zip'
      ],
      'application/x-zip-compressed' => [
        'extension' => 'zip',
        'type' => 'zip'
      ],
      'application/vnd.ms-excel' => [
        'extension' => 'csv',
        'type' => 'excel'
      ],
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => [
        'extension' => 'xlsx',
        'type' => 'excel'
      ],
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => [
        'extension' => 'docx',
        'type' => 'word'
      ],
      'text/xml' => [
        'extension' => 'xml',
        'type' => 'txt'
      ],
      'text/plain' => [
        'extension' => 'txt',
        'type' => 'txt'
      ],
      'image/jpeg' => [
        'type' => 'image'
      ],
      'image/png' => [
        'type' => 'image'
      ],
      'default' => [
        'extension' => 'txt',
        'type' => 'txt'
      ]
    ];
  }
