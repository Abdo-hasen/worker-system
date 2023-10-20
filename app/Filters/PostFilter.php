<?php
namespace App\Filters;

use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class PostFilter//b
{

    public function filters()
    {
        return[
            'content',
            'price',
            "worker.name",
            AllowedFilter::callback('item', function (Builder $query, $value) {//b
                $query->where("content","like","%{$value}%")//b
                ->orWhere("price","like","%{$value}%")//b
                ->orWhereHas("worker",function (Builder $query) use($value){//b
                    $query->Where("name","like","%{$value}%");
                });
            }),
        ];
    }
        
}


##################################
/*
-                 $query->where("content","like","%{$value}%")//b : 
- % فاليو % 
 بدور ع فاليو دي في اي مكان سواء اول او اخر او نص  

- % فاليو : 
بدور علي الفاليو  ف الاخر 
- فاليو %: 
بدور علي الفاليو  ف الاول 
- %  :عدد مجهول من عناصر او حروف 
- _  :حرف واحد مجهول


-             AllowedFilter::callback('item', function (Builder $query, $value) {//b  :
    - custom filter  : 
ex :  فلتر واحد يدور ف 3
name(or key of filter) - callback($query(filter),$value(of filter)) 

ex : {{url}}/worker/post/approved?filter[item]=7000

-                 ->orWhere("price","like","%{$value}%")//b  :
where types different 
############## 
- where + where = and
"دول يعني اند يعني لازم الاتنين يتحققوا "

- where
->orWhere 
"دي او دي او لاتنين"


-                 ->orWhereHas("worker",function (Builder $query) use($value){//b : 
    
     you use use when you want to access variables from the parent scope within a closure 
     "يعني دلوقتي عندي اول كلوجير فانكشن دي هي بارينت سكوب 
     وهيتتمرلها متغير 
     فلو محتاج المتغير ده في التشيلد سكوب اللي هو كلوجير فانكشن 
     جوا كلوجير بستخدم يوز "


- class PostFilter//b  :
ليه عملت كلاس فيلتر جوا فولدر فبتر 
كنوع من التنظيم
فالفولدر لان ممكن يبقي عندي فلاتر تانيه لموديلولز تانيه 
وتبقي كستوم برده 
وده كره بيبقي طويل فبحطها ف  فانكشن جوا كلاس  وبستخدمها 

فكده عشان اروق ع الكنتروولر عندي : 
كلاس : سبيسفيك بحاجه او موديول معين 
مثل : فلتر بوست

تريت : جنيرك 
مثل : ابلود ايمدج لاي موديول 

سيرفس : خطوات كتيره لفانكشن او لعمليه متقسمه ع محموعه فانكشن 
مثلا : عمليه حذف ومتقسمه لسوفت وهارد ديلديت 
او فانكشن لوجن فيها خطوات كتيره زي وركر 

ريبو باترن  : 
تيم ليدر عايز يعمل انترفيس 
او عمليه معقده ع الداتا بيز 

*/