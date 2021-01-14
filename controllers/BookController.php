<?php

namespace app\controllers;

use Yii;
use app\models\Modelbook;
use app\models\SearchBook;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Modelbook model.
 */
class BookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Modelbook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBook();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Modelbook model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }


    /**
     * Creates a new Modelbook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Modelbook();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
            if (Yii::$app->request->isAjax) {
                $model = new Modelbook();
                return $this->renderAjax('create', [
                    'model' => $model,
                ]);
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Modelbook model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data berhasil disimpan');
            if (Yii::$app->request->isAjax) {
                $model = new Modelbook();
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            } else {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Modelbook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    /**
     * Finds the Modelbook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Modelbook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Modelbook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCheck()
    {
        $buku = Modelbook::find()->select('id_buku')->orderBy('id_buku DESC')->one();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return ['lastId' => $buku->id_buku];
    }

    public function actionImport()
    {
        $modelImport = new \yii\base\DynamicModel([
            'fileImport' => 'File Import',
        ]);
        $modelImport->addRule(['fileImport'], 'required');
        $modelImport->addRule(['fileImport'], 'file', ['extensions' => 'ods,xls,xlsx'], ['maxSize' => 1024 * 1024]);

        if (Yii::$app->request->post()) {
            $modelImport->fileImport = \yii\web\UploadedFile::getInstance($modelImport, 'fileImport');
            if ($modelImport->fileImport && $modelImport->validate()) {
                $inputFileType = \PHPExcel_IOFactory::identify($modelImport->fileImport->tempName);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($modelImport->fileImport->tempName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                $baseRow = 3;
                while (!empty($sheetData[$baseRow]['A'])) {
                    $model = new Modelbook();
                    $model->nama_buku = (string)$sheetData[$baseRow]['A'];
                    $model->penerbit = (string)$sheetData[$baseRow]['B'];
                    $model->tahun_terbit = (string)$sheetData[$baseRow]['C'];
                    $model->save();
                    $baseRow++;
                }
                Yii::$app->getSession()->setFlash('success', 'Success');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Error');
            }
        }

        return $this->render('import', [
            'modelImport' => $modelImport,
        ]);
    }

    public function actionExportExcel()
    {
        $searchModel = new SearchBook();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        // $template = Yii::getAlias('@hscstudio/export') . '/templates/phpexcel/export.xlsx';
        $template = Yii::getAlias('@app/views/book') . '/export.xlsx';
        $objPHPExcel = $objReader->load($template);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_FOLIO);
        $baseRow = 3; // line 3
        foreach ($dataProvider->getModels() as $book) {
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $baseRow, $book->nama_buku);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $baseRow, $book->penerbit);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $baseRow, $book->tahun_terbit);
            $baseRow++;
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="export.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save('php://output');
        exit;
    }

    public function actionExportExcel2()
    {
        $searchModel = new SearchBook();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Initalize the TBS instance
        $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
        // Change with Your template kaka
        // $template = Yii::getAlias('@hscstudio/export') . '/templates/opentbs/ms-excel.xlsx';
        $template = Yii::getAlias('@app/views/book') . '/export2.xlsx';
        $OpenTBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).
        //$OpenTBS->VarRef['modelName']= "Mahasiswa";				
        $data = [];

        foreach ($dataProvider->getModels() as $book) {
            $data[] = [
                'nama_buku' => $book->nama_buku,
                'penerbit' => $book->penerbit,
                'tahun_terbit' => $book->tahun_terbit,
            ];
        }


        $OpenTBS->MergeBlock('data', $data);
        // Output the result as a file on the server. You can change output file
        $OpenTBS->Show(OPENTBS_DOWNLOAD, 'export.xlsx'); // Also merges all [onshow] automatic fields.			
        exit;
    }

    public function actionExportWord()
    {
        $searchModel = new SearchBook();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Initalize the TBS instance
        $OpenTBS = new \hscstudio\export\OpenTBS; // new instance of TBS
        // Change with Your template kaka
        // $template = Yii::getAlias('@hscstudio/export') . '/templates/opentbs/ms-excel.xlsx';
        $template = Yii::getAlias('@app/views/book') . '/export.docx';
        $OpenTBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).
        //$OpenTBS->VarRef['modelName']= "Mahasiswa";				
        $data = [];

        foreach ($dataProvider->getModels() as $book) {
            $data[] = [
                'nama_buku' => $book->nama_buku,
                'penerbit' => $book->penerbit,
                'tahun_terbit' => $book->tahun_terbit,
            ];
        }


        $OpenTBS->MergeBlock('data', $data);
        // Output the result as a file on the server. You can change output file
        $OpenTBS->Show(OPENTBS_DOWNLOAD, 'export.docx'); // Also merges all [onshow] automatic fields.			
        exit;
    }

    public function actionExportPdf()
    {
        $searchModel = new SearchBook();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $html = $this->renderPartial('_export', ['dataProvider' => $dataProvider]);
        $mpdf = new \mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;
    }
}
