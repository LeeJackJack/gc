<?php

    namespace App\Imports;

    use Illuminate\Support\Collection;
    use Maatwebsite\Excel\Concerns\ToCollection;
    use Speedy;

    class FirstSheetImport implements ToCollection
    {
        public function collection( Collection $rows )
        {
            $data = Speedy::getModelInstance( 'haizhu' )->first();
            foreach ( $rows as $key => $value )
            {
                if ( intval( $key ) > 5 && intval( $key ) < 22 )
                {
                    $add     = array_slice( $value->toArray() , 3 , 20 );
                    $str     = 'line' . ( intval( $key - 5 ) );
                    $lineArr = explode( ',' , $data[ $str ] );
                    $temp = [];
                    for ( $i = 0 ; $i < count( $add ) ; $i++ )
                    {
                        $temp[ $i ] = intval( $lineArr[ $i ] ) + intval( $add[ $i ] );
                    }
                    Speedy::getModelInstance( 'haizhu' )->first()->update(
                        [
                            'line' . ( intval( $key - 5 ) ) => implode( ',' , $temp ) ,
                        ] );
                }
            }
        }
    }


