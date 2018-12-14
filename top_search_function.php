<?php
    function judge_method(string $method){//収入と支出を判定するjudgemethod関数
        if($method == '1') {
            print '支出';//1であれば支出
        } else {//1でない場合
            print '収入';//収入
        }
    } 

    function judge_category(string $category){//カテゴリを判定する為のjudgecategory関数（仮）
    //POST情報に割り当てられた数字からカテゴリを判断し、表示する
        switch($category){
            case '0':
                print '食費';
                break;
            case '1':
                print '交際費';
                break;
            case '2':
                print 'ゲーム';
                break;
            case '3';
                print '収入';
                break;
        }
    }
