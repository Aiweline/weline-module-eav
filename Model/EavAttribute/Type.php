<?php
declare(strict_types=1);

/*
 * 本文件由 秋枫雁飞 编写，所有解释权归Aiweline所有。
 * 作者：Admin
 * 邮箱：aiweline@qq.com
 * 网址：aiweline.com
 * 论坛：https://bbs.aiweline.com
 * 日期：2023/3/6 21:28:26
 */

namespace Weline\Eav\Model\EavAttribute;

use Weline\Eav\Model\EavAttribute;
use Weline\Framework\Database\Api\Db\Ddl\TableInterface;
use Weline\Framework\Manager\ObjectManager;
use Weline\Framework\Setup\Data\Context;
use Weline\Framework\Setup\Db\ModelSetup;

class Type extends \Weline\Framework\Database\Model
{
    public const fields_ID           = 'type_id';
    public const fields_type_id      = 'type_id';
    public const fields_code         = 'code';
    public const fields_name         = 'name';
    public const fields_field_type   = 'field_type';
    public const fields_field_length = 'field_length';
    public array $_unit_primary_keys = ['type_id'];
    public array $_index_sort_keys = ['type_id'];

    /**
     * @inheritDoc
     */
    public function setup(ModelSetup $setup, Context $context): void
    {
        $this->install($setup, $context);
    }

    /**
     * @inheritDoc
     */
    public function upgrade(ModelSetup $setup, Context $context): void
    {
        // TODO: Implement upgrade() method.
    }

    /**
     * @inheritDoc
     */
    public function install(ModelSetup $setup, Context $context): void
    {
//        $setup->dropTable();
        if (!$setup->tableExist()) {
            $setup->createTable('属性类型表')
                  ->addColumn(
                      self::fields_ID,
                      TableInterface::column_type_INTEGER,
                      0,
                      'primary key auto_increment',
                      '类型ID')
                  ->addColumn(
                      self::fields_code,
                      TableInterface::column_type_VARCHAR,
                      255,
                      'unique not null',
                      '类型代码')
                  ->addColumn(
                      self::fields_name,
                      TableInterface::column_type_VARCHAR,
                      255,
                      'not null',
                      '类型名')
                  ->addColumn(
                      self::fields_field_type,
                      TableInterface::column_type_VARCHAR,
                      60,
                      'not null',
                      '数据库字段类型')
                  ->addColumn(
                      self::fields_field_length,
                      TableInterface::column_type_SMALLINT,
                      5,
                      'not null',
                      '数据库字段长度')
                  ->addIndex(TableInterface::index_type_KEY, 'idx_code', self::fields_code)
                  ->create();
            $this->insert([
                              [
                                  self::fields_code         => 'input_string_60',
                                  self::fields_field_type   => TableInterface::column_type_VARCHAR,
                                  self::fields_field_length => '60',
                                  self::fields_name         => '字符串输入（60字节）',
                              ],
                              [
                                  self::fields_code         => 'input_int',
                                  self::fields_field_type   => TableInterface::column_type_INTEGER,
                                  self::fields_field_length => 0,
                                  self::fields_name         => '数字输入',
                              ],
                              [
                                  self::fields_code         => 'input_bool',
                                  self::fields_field_type   => TableInterface::column_type_SMALLINT,
                                  self::fields_field_length => 1,
                                  self::fields_name         => '布尔值输入',
                              ],
                          ],
                          self::fields_code
            )->fetch();
        }
    }

    function getName(): string
    {
        return $this->getData(self::fields_name) ?: '';
    }

    function setName(string $name): static
    {
        return $this->setData(self::fields_name, $name);
    }

    function getCode(): string
    {
        return $this->getData(self::fields_code) ?: '';
    }

    function setCode(string $code): static
    {
        return $this->setData(self::fields_code, $code);
    }

    function getFieldType(): string
    {
        return $this->getData(self::fields_field_type) ?: '';
    }

    function setFieldType(string $field_type): static
    {
        return $this->setData(self::fields_field_type, $field_type);
    }

    function getFieldLength(): int
    {
        return intval($this->getData(self::fields_field_length));
    }

    function setFieldLength(int $field_length): static
    {
        return $this->setData(self::fields_field_length, $field_length);
    }

    /**
     * @DESC          # 获取关联属性类型的属性模型
     *
     * @AUTH    秋枫雁飞
     * @EMAIL aiweline@qq.com
     * @DateTime: 2023/7/27 22:22
     * 参数区：
     */
    public function getAttributeModel():EavAttribute
    {
        /**@var EavAttribute $attrbiute */
        $attrbiute = ObjectManager::getInstance(EavAttribute::class);
        $attrbiute->where(EavAttribute::fields_type_id, $this->getId());
        return $attrbiute;
    }
}