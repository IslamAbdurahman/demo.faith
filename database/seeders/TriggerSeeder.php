<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TriggerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select("
        CREATE TRIGGER `payments_before_delete` BEFORE DELETE ON `payments` FOR EACH ROW BEGIN

    declare t_id int;
    declare percent_ int;

    update kassa set balance=balance-OLD.amount where id = OLD.kassa_id;

    select t.id into t_id from payments p
                                   join graphics gr on gr.id = p.graphic_id
                                   join `groups` g on g.id = gr.group_id
                                   join users t on t.id = g.teacher_id

    where gr.id =OLD.graphic_id limit 1;

    update graphics set paid_amount=paid_amount-OLD.amount,
                        remaining_amount=remaining_amount+old.amount
    where id=old.graphic_id;


    select g.percent into percent_ from  payments p
                                join graphics gr on gr.id = p.graphic_id
                                join `groups` g on gr.group_id = g.id
    where g.teacher_id =t_id and gr.id = OLD.graphic_id limit 1;

    update users set balance = balance-(OLD.amount/100*percent_) where id=t_id;



END
        ");

        DB::select("
CREATE TRIGGER `payments_before_insert` BEFORE INSERT ON `payments` FOR EACH ROW BEGIN

    declare t_id int;
    declare percent_ int;

    update kassa set balance=balance+NEW.amount where id = NEW.kassa_id;

    select t.id into t_id from graphics gr
                                   join `groups` g on g.id = gr.group_id
                                   join users t on t.id = g.teacher_id
    where gr.id =NEW.graphic_id limit 1;

    update graphics set paid_amount=paid_amount+NEW.amount,
                        remaining_amount=remaining_amount-NEW.amount
    where id=NEW.graphic_id;


    select g.percent into percent_ from  graphics gr
                                             join `groups` g on gr.group_id = g.id
    where g.teacher_id =t_id and gr.id = NEW.graphic_id limit 1;

    update users set balance = balance+(NEW.amount/100*percent_) where id=t_id;

END
        ");

        DB::select("
CREATE TRIGGER `salaries_before_delete` BEFORE DELETE ON `salaries` FOR EACH ROW BEGIN

    update kassa set balance=balance+OLD.amount where id = OLD.kassa_id;

    update users set balance = balance+OLD.amount where id=OLD.worker_id and role=4;

END
        ");

        DB::select("
        CREATE TRIGGER `salaries_before_insert` BEFORE INSERT ON `salaries` FOR EACH ROW BEGIN

    update kassa set balance=balance-NEW.amount where id = NEW.kassa_id;

    update users set balance = balance-NEW.amount where id=NEW.worker_id and role=4;

END
        ");

        DB::select("
        CREATE TRIGGER `student_groups_before_delete` BEFORE DELETE ON `student_groups` FOR EACH ROW BEGIN

    delete from graphics where graphics.student_id = OLD.student_id
                        and graphics.group_id = old.group_id
                        and paid_amount = 0;


END
        ");

        DB::select("
CREATE TRIGGER `transactions_after_update` BEFORE UPDATE ON `transactions` FOR EACH ROW BEGIN

    declare kassa_ int;
    declare user_id_ int;
    declare student_id_ int;
    declare month_id_ int;
    declare kitchen_ int;
    declare bedroom_ int;
    declare education_ int;

    select id into user_id_ from users where role=1 limit 1;
    select id into kassa_ from kassa where is_click = 1 limit 1;
    select student_id into student_id_ from  graphics where id = new.transactionable_id limit 1;
    select graphics.month into month_id_ from  graphics where id = new.transactionable_id limit 1;
    select graphics.kitchen into kitchen_ from  graphics where id = new.transactionable_id limit 1;
    select graphics.bedroom into bedroom_ from  graphics where id = new.transactionable_id limit 1;
    select graphics.education into education_ from  graphics where id = new.transactionable_id limit 1;

  if OLD.state = 1 AND NEW.state = 2 then

      insert into payments set
                               month_id = month_id_,
                               amount = new.amount,
                               kitchen = kitchen_,
                               bedroom = bedroom_,
                               education = education_,
                               user_id = user_id_,
                               graphic_id = NEW.transactionable_id,
                               student_id = student_id_,
                               kassa_id=kassa_,
                               transaction_id = NEW.id,
                               payments.date = NEW.updated_at;

  end if;

    if OLD.state = 2 AND NEW.state = -2 then
        delete from payments where payments.transaction_id = NEW.id;
    end if;





END
        ");

    }
}
