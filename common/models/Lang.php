<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lang".
 *
 * @property int $id
 * @property string $name
 * @property string $iso
 * @property string $flag
 *
 * @property LangHasCategory[] $langHasCategories
 * @property Category[] $categories
 * @property LangHasDoctor[] $langHasDoctors
 * @property Doctor[] $doctors
 * @property LangHasFooterMenu[] $langHasFooterMenus
 * @property FooterMenu[] $footerMenus
 * @property LangHasHelpInfo[] $langHasHelpInfos
 * @property HelpInfo[] $helpInfos
 * @property LangHasHospital[] $langHasHospitals
 * @property Hospital[] $hospitals
 * @property LangHasLibrary[] $langHasLibraries
 * @property Library[] $libraries
 * @property LangHasMenu[] $langHasMenus
 * @property Menu[] $menus
 * @property LangHasNews[] $langHasNews
 * @property News[] $news
 * @property LangHasPage[] $langHasPages
 * @property Page[] $pages
 * @property LangHasSubMenu[] $langHasSubMenus
 * @property SubMenu[] $subMenus
 * @property LangHasType[] $langHasTypes
 * @property Type[] $types
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'iso', 'flag'], 'required'],
            [['name', 'flag'], 'string', 'max' => 255],
            [['iso'], 'string', 'max' => 45],
            [['iso'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('admin', 'ID'),
            'name' => Yii::t('admin', 'Name'),
            'iso' => Yii::t('admin', 'Iso'),
            'flag' => Yii::t('admin', 'Flag'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasCategories()
    {
        return $this->hasMany(LangHasCategory::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('lang_has_category', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasDoctors()
    {
        return $this->hasMany(LangHasDoctor::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasMany(Doctor::className(), ['id' => 'doctor_id'])->viaTable('lang_has_doctor', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasFooterMenus()
    {
        return $this->hasMany(LangHasFooterMenu::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFooterMenus()
    {
        return $this->hasMany(FooterMenu::className(), ['id' => 'footer_menu_id'])->viaTable('lang_has_footer_menu', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasHelpInfos()
    {
        return $this->hasMany(LangHasHelpInfo::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpInfos()
    {
        return $this->hasMany(HelpInfo::className(), ['id' => 'help_info_id'])->viaTable('lang_has_help_info', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasHospitals()
    {
        return $this->hasMany(LangHasHospital::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHospitals()
    {
        return $this->hasMany(Hospital::className(), ['id' => 'hospital_id'])->viaTable('lang_has_hospital', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasLibraries()
    {
        return $this->hasMany(LangHasLibrary::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibraries()
    {
        return $this->hasMany(Library::className(), ['id' => 'library_id'])->viaTable('lang_has_library', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasMenus()
    {
        return $this->hasMany(LangHasMenu::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id' => 'menu_id'])->viaTable('lang_has_menu', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasNews()
    {
        return $this->hasMany(LangHasNews::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])->viaTable('lang_has_news', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasPages()
    {
        return $this->hasMany(LangHasPage::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['id' => 'page_id'])->viaTable('lang_has_page', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasSubMenus()
    {
        return $this->hasMany(LangHasSubMenu::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubMenus()
    {
        return $this->hasMany(SubMenu::className(), ['id' => 'sub_menu_id'])->viaTable('lang_has_sub_menu', ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLangHasTypes()
    {
        return $this->hasMany(LangHasType::className(), ['lang_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['id' => 'type_id'])->viaTable('lang_has_type', ['lang_id' => 'id']);
    }
}
