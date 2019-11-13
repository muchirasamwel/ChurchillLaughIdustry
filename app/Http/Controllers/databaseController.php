<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller; 
use Illuminate\Support\facades\Crypt;
use Mail;
session_start();
//This class is a hybrid class with my own made code and a few tricks of laravel eloquent model
class databaseController extends Controller
{
/*
*I decided not to use eloquent to handle database control beacause i *clafted this class and it has proven to make my database work easier.
*/
      public function incrticket(Request $request)
      {

        $query="UPDATE `events` SET `totalbooking`=(totalbooking+1) WHERE id=".$request->input("id");
        if($request->input("incriment")=="less")
        {
        $query="UPDATE `events` SET `totalbooking`=(totalbooking-1) WHERE id='".$request->input("id")+"'";
        }
        try{
          DB::update($query);
          return "success";
        }catch(Exception $e){
          return "error";
        }

      }
      //This function handles all my update query
      public function update(Request $request)
        {
          $result = $this->up($request);
          return $result;
      }
      //This function handles all my delete query
      public function delete(Request $request)
         {
          $result = $this->del($request);
          return $result;
      }
      //This function handles all my insert query
      public function insert(Request $request){
         $table=$request->input('table');
         if($table=="bookings")
         {
            $query="select * from bookings where constrnt='".$request->input('constrnt')."'"; 
            $tot=DB::select($query);
            $count=count($tot);
            var_dump($count);
            if($count>=5)
            {
             /// var_dump($tot[0]);
              return "Maximum Tickets reached for this event";
            }
         }
         $db_columns=$this->columns($table);
         $columns=[];
         $values=[];
         foreach ($request->input() as $key => $value) {
           // echo "<br> key=".$key.'<br>';
           // echo "value=".$value.'<br>';
            if (array_search($key,$db_columns) && $key!='id') {
              if($key=="password" && (!is_null($value)))
              {
                $columns[]=$key;
                $values[]="'".Crypt::encrypt($value)."'";
              }
              else if(($key!="password" && (!is_null($value)))||$key=="created_at"){
                  if($key=="created_at")
                  {
                    $result = date('Y-m-d H:i:s');
                    //$result = $date->format('Y-m-d H:i:s');
                    $value=$result;
                  }
                  $columns[]=$key;
                  $values[]="'".$value."'";
              }
            }
         }
         $columns=join(",",$columns);
         $values=join(",",$values);
         $query="insert into $table ($columns) values ($values)";
        //var_dump($query);
         try {
           DB::insert($query);
          return 'insert successful';
         } catch (Exception $e) {
           return $e;
         }
        // echo "Record inserted successfully.<br/>";
      }
      //This function handles all my select query
      public function select(Request $request){
        $result=$this->cur_select($request);
        
       return ($result);
       }
       //This function implements the select logic
      function cur_select($request){
        $table=$request->input('table');
        $columns=$this->columns($table);
        $query="select * from $table";
        if(count($request->input())>2)
           {
              $query=$query." where ";
              foreach ($request->input() as $key => $value) {

              if ((array_search($key,$columns) || $key=='id')&&($key!='join_type')&&($key!='_token')&&($key!='password')) {
                 if(!is_null($request->input('join_type')))
                 {
                  //if(!is_null($value))
                    $query=$query."$key='$value' or ";
                 }
                 else{
                 // if(!is_null($value))
                    $query=$query."$key='$value' and ";
                 }
              }
           }
           if(!is_null($request->input('join_type')))
              $query=substr_replace($query, "", -4);
           else
              $query=substr_replace($query, "", -5);
        }
       // echo "<br>query".$query."<br>";
        $result=DB::select($query);
        //var_dump($result);
        $data=$this->as_dict($result);
        return $data;
   }
      //This function handles all my login requests
      public function login(Request $request){
        $result=$this->cur_select($request);
        $result1=json_decode($result);
        $result1=$result1[0];
        //var_dump($result[]);
        if($result!="no results"){
          if($result1->status=="Waiting"){
            $activationcode=$request->input('activation');
            if($activationcode==$result1->verificationcode)
            {
               $query="update users set status='Active' where id=".$result1->id;
               DB::update($query);
            }
            else
              return "waiting";
          }
          else if($result1->status=="Suspended")
            return "suspended";
          try {
                 $password=$request->input('password');
                 $passdata=json_decode($result);
                 $encrypteddata=$passdata[0]->password;
                  $decrypted = Crypt::decrypt($encrypteddata);
                  if($password==$decrypted && $passdata[0]->status =='Active')
                  {
                    foreach ($passdata as $row ) {
                      foreach ($row as $key => $value) {
                        if($key!='password')
                         $_SESSION[$key]=$value;
                        // $GLOBALS[$key]
                      }
                    }
                   //var_dump();
                    return ($result);
                  }
                  else
                  {
                    if($passdata[0]->status !='Active' && $password==$decrypted )
                    return ($result);
                  else
                    return 'no results';
                  }
                  //var_dump($decrypted);
              } catch (DecryptException $e) {
                  //
              }
            }
         
       return ($result);
       }
      //This function helps me get the columns from a specific table
      function columns($table){
         $query="DESCRIBE $table";
         $result=DB::select($query);
         $rows=[];
         if ($result) {
            foreach ($result as $row ) {
               $rows[]=$row->Field;
            }
           // var_dump($rows);
         }
         return $rows;
      }
      // this function creates my data in the format that i can handle well in javascript. (creates a dictionary)
      function as_dict($result){
         $data=[];
          if (count($result)> 0) {
            foreach ($result as $row ) {
               $data[]=$row;
               }
           // echo ('<script>console.log($data);</script>');
            $data=json_encode($data);
           }
           else{
              $data="no results";
           }
           
           return $data;
      }
      //this function creates a php session which will be used to identify users
      public function refreshsession($request)
      {
            $passdata=json_decode($request);
            foreach ($request->input() as $key => $value) {
              if(!is_null($value)){
                  if($key!='password')
                   $_SESSION[$key]=$value;
               }
            }
              if($request->input('table')=="farmers"){
                $_SESSION['username']=$passdata[0]->full_name;
                $_SESSION['user_type']='Farmer';
              }
              return true;
       }
      //This function implements the update logic
      function up($request){
         $id=$request->input('id');
         $usdata=$request->input('usdata');
         $table=$request->input('table');
         $columns=$this->columns($table);

         $query="update $table set ";
         foreach ($request->input() as $key => $value) {
           # code...
           if ($key!='id' && array_search($key,$columns)) {

              if(!is_null($value)||$key=="updated_at"){
                  if($key=="password")
                  {
                    $value=Crypt::encrypt($value);
                  }
                  if($key=="updated_at")
                  {
                    $result =date('Y-m-d H:i:s');
                    //$result = $date->format('Y-m-d H:i:s');
                    $value=$result;
                  }
                  $query=$query."$key='".$value."',";
               }
           }
         }
         $query=substr_replace($query, "", -1);
         $query=$query." where id=$id";
          //echo "<br> $query <br>";
         // var_dump($query);
          try {
            DB::select($query);
            if($usdata=='user')
              $this->refreshsession($request);
            return "update successful";
          } catch (Exception $e) {
           return "Update Error";
            
          }
         
      }
      //This function implements the delete logic
      function del($request){
         $id=$request->input('id');
         $table=$request->input('table');
         $query="delete from $table where id=$id";
         try {
             DB::select($query);
             return "delete successful";
         } catch (Exception $e) {
           return "Delete Error";
         }
     }
   
}
