<?php

  function currencySet($amt){
   $rates=session()->get('rates');
   //echo "<br />";
   $currency=session()->get('currency');
   //exit;
    if($currency=='USD')     return $amt*$rates;
    elseif($currency=='INR') return $amt;
    elseif($currency=='EUR') return $amt*$rates;
  }

  function AdmincurrencySet($amt,$currency){
     if($currency=='USD') return $amt*0.013;
     elseif($currency=='INR') return $amt;
     elseif($currency=='EUR') return $amt*0.012;
   }

   function AdmingetSymbol($currency){
    if($currency=='USD') return "$";
    elseif($currency=='INR') return "Rs ";
    elseif($currency=='EUR') return "€ ";
  }

  function getSymbol(){
    $currency=session()->get('currency');
    if($currency=='USD') return "$";
    elseif($currency=='INR') return "Rs ";
    elseif($currency=='EUR') return "€ ";
  }

  function Sess(){  return session()->all(); }
