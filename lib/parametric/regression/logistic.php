<?php

   function _ll_logistic_gradient_descent($xs, $ys, $initialization=null, $learning_rate=null, $regularization=null, $repetitions=null, $convergence=null)
   {
   		return _ll_gradient_descent("__ll_logistic_min_function", "__ll_logistic_cost_function_derivative", $xs, $ys, $initialization, $learning_rate, $re, $repetitions, $convergence);
   }

   function __ll_sigmoid($x)
   {
   		return (1/(1+exp($x)));
   }

   function __ll_logistic_min_function($xs, $ys, $parameters)
   {
      $result = 0;
      for($i=0;$i<count($ys);$i++)
      {
      	 $h_xi = __ll_logistic_hypothesis_function($xs[$i], $parameters);
      	 $result += ((-1) * $ys[$i] * log($h_xi) - (1-$ys[$i])*log(1-$h_xi));
      }
      return $result;
   }

   function __ll_logistic_cost_function_derivative($xs, $ys, $parameters, $wrt=0)
   {
      $data_count = count($ys);
      $result = 0;
      for($i=0;$i<$data_count;$i++)
      {
         $result += ((__ll_logistic_hypothesis_function($xs[$i], $parameters) - $ys[$i]) * $xs[$i][$wrt]);
      }
      $result *= (1/$data_count);


      if($regularization !== null)
      {
         $regular = 0;
         for($i=1;$i<count($parameters);$i++)
         {
            $regular += pow($parameters[$i], 2);
         }
         $regular *= $regularization;
         $result += $regular;
      }
      return $result;
   }

   function __ll_logistic_hypothesis_function($x_row, $parameters, $regularization=null)
   {
      if(count($parameters) != count($x_row))
         return false;

      $result = 0;
      for($i=0;$i<count($parameters);$i++)
         $result += $x_row[$i] * $parameters[$i];

      if($regularization !== null)
      {
         $regular = 0;
         for($i=1;$i<count($parameters);$i++)
         {
            $regular += pow($parameters[$i], 2);
         }
         $regular *= $regularization;
         $result += $regular;
      }

      // i think this might be broken, we might not need to sigmoid here.
      $result = __ll_sigmoid(exp($result * (-1)));

      return $result;
   }
?>